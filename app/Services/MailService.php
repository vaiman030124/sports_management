<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;
use App\Models\EmailTemplate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\HtmlString;

class MailService
{
    public function sendEmailUsingTemplate(string $toEmail, string $templateSlug, array $variables = [])
    {
        $template = EmailTemplate::where('slug', $templateSlug)
            ->where('status', 'active')
            ->first();

        if (!$template) {
            throw new \Exception("Email template of type '{$templateSlug}' not found or inactive.");
        }
        // Render subject and body with variables using Blade
        $subject = $this->renderBladeString($template->subject, $variables);
        $body = $this->renderBladeString($template->body, $variables);

        Mail::raw($body, function ($message) use ($toEmail, $subject) {
            $message->to($toEmail)
                ->subject($subject);
        });
    }

    /**
     * Render a Blade string with given variables.
     *
     * @param string $string
     * @param array $variables
     * @return string
     */
    protected function renderBladeString(string $string, array $variables = [])
    {
        $php = Blade::compileString($string);

        ob_start() and extract($variables, EXTR_SKIP);

        try {
            eval('?>' . $php);
        } catch (\Exception $e) {
            ob_end_clean();
            throw $e;
        }

        $content = ob_get_contents();
        ob_end_clean();

        return $content;
    }
}
