<?php

namespace App\Services\Exports;

use App\Models\WeeklyReports;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class WeeklyReportsExportService
{
    public function exportCertifiedReports($reports)
    {
        \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);

        $zip = new ZipArchive();
        $zipFileName = 'weekly_reports.zip';
        $zipPath = storage_path("app/temp/{$zipFileName}");

        $zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE);

        $php = new PhpWord();
        $section = $php->addSection();


        $reports = WeeklyReports::where('status', 'certified')->with('user')->get();
        foreach ($reports as $report) {

            $php = new PhpWord();
            $php->setDefaultFontName('Arial');
            $php->setDefaultFontSize(11);

            $section = $php->addSection();

            $titleStyle = ['alignment' => 'center', 'bold' => true, 'size' => 14];
            $sectionTitleStyle = ['bold' => true];
            $labelStyle = ['bold' => true];

            // Title
            $section->addText('OJT WEEKLY REPORT', $titleStyle);
            $section->addTextBreak(1);

            // Header
            $section->addText("Week of: {$report->week_start}", ['underline' => 'single']);
            $section->addText("Name: {$report->user->name}", ['underline' => 'single']);
            $section->addTextBreak(1);

            $entries = $report->entries;

            if (is_string($entries)) {
                $entries = json_decode($entries, true) ?? [];
            }

                // WEEK FOCUS 
                $section->addText('1. WEEK FOCUS', $sectionTitleStyle);
                $section->addText('What was your main focus this week?');
                $section->addTextBreak(1);
                $section->addText('Answer:', $labelStyle);
                $section->addText($entries['week_focus']);
                $section->addTextBreak(2);


                // TOPICS & CONCEPTS LEARNED 
                    $section->addText('2. TOPICS & CONCEPTS LEARNED', $sectionTitleStyle);
                    $section->addText('Topics:', $labelStyle);
                    foreach ($entries['topics_learned'] as $topic) {
                        $section->addText(
                            htmlspecialchars($topic, ENT_QUOTES | ENT_XML1, 'UTF-8')
                        );
                    }

                // OUTPUTS & LINKS
                $section->addTextBreak(1);
                    $section->addText('3. OUTPUTS & LINKS', $sectionTitleStyle);
                    foreach ($entries['outputs_links'] as $link) {
                        if (isset($link['url'])) {
                            $section->addLink(
                                $link['url'],$link['url']
                            );
                            $section->addText($link['description']);
                        }
                        $section->addTextBreak();
                    }

                // WHAT YOU BUILT OR DESIGNED
                $section->addText('4. WHAT YOU BUILT OR DESIGNED', $sectionTitleStyle);
                $section->addText('Describe what you created and what problem it was meant to solve.', $sectionTitleStyle);
                $section->addText('Answer:', $labelStyle);
                $section->addText($entries['what_built']);
                $section->addTextBreak(2);
                 

                // DECISIONS & REASONING
                $section->addTextBreak(1);
                    $section->addText('5. DECISIONS & REASONING', $sectionTitleStyle);
                    $section->addText('Decision 1:', $labelStyle);
                    $section->addText($entries['decisions_reasoning']['decision_1'] ?? '');
                    $section->addText('Decision 2:', $labelStyle);
                    $section->addText($entries['decisions_reasoning']['decision_2'] ?? '');      

                 // CHALLENGES & BLOCKERS
                 $section->addText('6. CHALLENGES & BLOCKERS ', $sectionTitleStyle);
                 $section->addText('What was difficult or confusing? What slowed you down?', $sectionTitleStyle);
                 $section->addText('Answer:', $labelStyle);
                 $section->addText($entries['challenges_blockers']);
                 $section->addTextBreak(2);

                 // WHAT YOU BUILT OR DESIGNED
                 $section->addText('7. WHAT YOU’D IMPROVE NEXT TIME', $sectionTitleStyle);
                 $section->addText('If you had more time, what would you improve or change?', $sectionTitleStyle);
                 $section->addText('Decision 1:', $labelStyle);
                 $section->addText($entries['improve_next_time']['improvement_1'] ?? '');
                 $section->addText('Decision 2:', $labelStyle);
                 $section->addText($entries['improve_next_time']['improvement_2'] ?? '');  

            // Save
            $safeName = preg_replace('/[^A-Za-z0-9 _-]/', '', $report->user->name);
            $fileName = "Weekly_Report_{$safeName}.docx";
            $tempPath = storage_path("app/temp/{$fileName}");

            Storage::makeDirectory('temp');
            $writer = IOFactory::createWriter($php, 'Word2007');
            $writer->save($tempPath);

            clearstatcache(true, $tempPath);


            if (!file_exists($tempPath) || filesize($tempPath) < 1000) {
                throw new \Exception('DOCX file was not written correctly.');
            }

            usleep(200000);

            $zip->addFile($tempPath, $fileName);

        }

        $zip->close();

        return response()->download($zipPath)->deleteFileAfterSend(true);
    }
}