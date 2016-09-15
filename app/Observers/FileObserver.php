<?php namespace App\Observers;

use Excel;
use Modules\Media\Events\FileWasUploaded;
use PdfParser;

class FileObserver
{

    public $file;

    /**
     * @param FileWasUploaded $event
     */
    public function handle(FileWasUploaded $event)
    {

        $this->file = $event->file;
        $text       = '';
        $fullPath   = base_path('public' . $this->file->path);
        if ($this->file->extension == 'pdf') {
            $parser = new PdfParser();
            $pdf    = $parser->parseFile($fullPath);
            $text   = $pdf->getText();
        }
        if ($this->file->extension == 'docx') {
            $text = $this->docx2text($fullPath);
        }
        if (in_array($this->file->extension, ['xls', 'xlsx', 'csv'])) {
            $textFromExcel = [];
            Excel::load($fullPath, function ($reader) use (&$textFromExcel) {
                $textFromExcel[] = $reader->getTitle();
                // Get first 5 rows to make a description.
                $rows = $reader->take(5)->toArray();
                foreach ($rows as $row) {
                    if (count((array)$row)) {
                        $textFromExcel[] = implode(' ', (array)$row);
                    }
                }
            });
            if (count($textFromExcel)) {
                $text = implode(' ', $textFromExcel);
            }
        }
        if (mb_strlen($text) > 0) {
            $this->file->description = $this->getShortDescription($text);
            $this->file->save();
        }
    }

    private function getShortDescription($text)
    {
        $text = trim($text);
        return ((mb_strlen($text) <= 300) ? $text : mb_substr($text, 0, 300 - 3) . '...');
    }

    private function docx2text($filename)
    {
        return $this->readZippedXML($filename, "word/document.xml");
    }

    private function readZippedXML($archiveFile, $dataFile)
    {
        $zip = new \ZipArchive;
        // Open received archive file.
        if ($zip->open($archiveFile)) {
            // If done, search for the data file in the archive.
            if (($index = $zip->locateName($dataFile)) !== false) {
                $data = $zip->getFromIndex($index);
                $zip->close();
                $xml = new \DOMDocument();
                $xml->loadXML($data, LIBXML_NOENT | LIBXML_XINCLUDE | LIBXML_NOERROR | LIBXML_NOWARNING);
                return strip_tags($xml->saveXML());
            }
            $zip->close();
        }
        return "";
    }
}
