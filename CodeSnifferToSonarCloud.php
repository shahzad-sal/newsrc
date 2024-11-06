<?php

class CodeSnifferToSonarCloud
{
    private const SONARCLOUD_FILE = 'codesniffer-report.json';
    public function __construct(
        private readonly ?string $filePath
    ) {
    }

    public function storeSonarCloudFormat(): void
    {
        if (!file_exists($this->filePath)) {
            return;
        }

        try {
            $codesnifferFile = fopen($this->filePath, 'r');
            $codesnifferTxt = '';
            while (!feof($codesnifferFile)) {
                $codesnifferTxt .= fgets($codesnifferFile);
            }

            $issues = $this->convertToSonarCloudFormat(json_decode($codesnifferTxt, true));
            if (!count($issues)) {
                echo 'No codesniffer issues' . PHP_EOL;
            } else {
                echo 'Saved Codesniffer issues to SonarCloud format' . PHP_EOL;
            }


            $this->saveIssuesToJsonFile(['issues' => $issues]);
        } catch (Throwable $e) {
            echo $e->getMessage();
            echo 'No codesniffer report';
        }
    }

    private function convertToSonarCloudFormat(array $codeSnifferIssues): array
    {
        if (!array_key_exists('files', $codeSnifferIssues)) {
            return [];
        }

        $sonarCloudIssues = [];
        foreach ($codeSnifferIssues['files'] as $filePath => $issue) {
            if (count($issue['messages'])) {
                foreach ($issue['messages'] as $message) {
                    $sonarCloudIssues[] = $this->sonarCloudIssue($filePath, $message);
                }
            }
        }

        return $sonarCloudIssues;
    }

    private function saveIssuesToJsonFile(array $issues): void
    {
        $sonarCloudFile = fopen(self::SONARCLOUD_FILE, 'w') or die('Can not open file');
        $sonarCloudJson = json_encode($issues);
        fwrite($sonarCloudFile, $sonarCloudJson);
        fclose($sonarCloudFile);
    }

    private function sonarCloudIssue(string $filePath, array $message): array
    {
        return [
            'engineId' => 'PHPCS',
            'ruleId' => $message['source'],
            'severity' => $this->getSeverity($message['severity']),
            'type' => 'CODE_SMELL',
            'primaryLocation' => [
                "message" => $message["message"],
                "filePath" => $filePath,
                "textRange" => [
                    "startLine" => $message["line"],
                    // "startColumn" => $message["column"]
                ]
            ]
        ];
    }

    private function getSeverity(int $severity): string
    {
        return match ($severity) {
            2, 3 => 'MINOR',
            4, 5 => 'MAJOR',
            6, 7 => 'CRITICAL',
            8, 9, 10 => 'BLOCKER',
            default => 'INFO',
        };
    }
}

$sonarCloud = new CodeSnifferToSonarCloud('codesniffer.json');
$sonarCloud->storeSonarCloudFormat();
