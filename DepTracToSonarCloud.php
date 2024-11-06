<?php

class DepTracToSonarCloud
{
    private const SONARCLOUD_FILE = 'deptrac-report.json';
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
            $depTracFile = fopen($this->filePath, 'r');
            $depTracFileText = '';
            while (!feof($depTracFile)) {
                $depTracFileText .= fgets($depTracFile);
            }

            $issues = $this->convertToSonarCloudFormat(json_decode($depTracFileText, true));
            if (!count($issues)) {
                echo 'No deptrac issues' . PHP_EOL;
            } else {
                echo 'Saved deptrac issues to SonarCloud format' . PHP_EOL;
            }

            $this->saveIssuesToJsonFile(['issues' => $issues]);
        } catch (Throwable $e) {
            echo $e->getMessage();
            echo 'No deptrac report';
        }
    }

    private function convertToSonarCloudFormat(array $depTracIssues): array
    {
        $sonarCloudIssues = [];
        foreach ($depTracIssues as $issue) {
                    $sonarCloudIssues[] = [
                        'engineId' => 'DepTrac',
                        'ruleId' => $issue['check_name'],
                        'severity' => strtoupper($issue['severity']),
                        'type' => $issue['type'],
                        'primaryLocation' => [
                            "message" => $issue['description'],
                            "filePath" => str_replace(getcwd() . '/', '', $issue['location']['path']),
                            "textRange" => [
                                "startLine" => $issue['location']['lines']['begin'],
                            ]
                        ]
                    ];
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
}

$sonarCloud = new DepTracToSonarCloud('deptrac.json');
$sonarCloud->storeSonarCloudFormat();
