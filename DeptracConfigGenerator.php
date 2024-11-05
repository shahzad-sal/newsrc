<?php
declare(strict_types=1);

require 'vendor/autoload.php';


class DeptracConfigGenerator
{
    private const DOMAINS = [
        'Domain',
        'Application',
        'Infrastructure',
        'Presentation'
    ];
    public function __construct(
        private readonly array $changedFiles,
        private readonly string $tempConfigFile = 'deptrac.extended.layers.yaml',
        private array $layers = [],
    ) {
    }

    public function generateConfig(): void
    {
        foreach (self::DOMAINS as $domain) {
            $collectors = [];
            if (!empty($this->changedFiles)) {
                foreach ($this->changedFiles as $file) {
                    if (preg_match("/src\/$domain\/.*/", $file)) {
                        $relativePath = str_replace(['src/', '.php'], '', $file);
                        $relativePath = str_replace('/', '\\\\', $relativePath);
                        $collectors[] = ['type' => 'class', 'value' => "^$relativePath.*$"];
                    }
                }
            }
            if (empty($collectors)) {
                $collectors[] = ['type' => 'class', 'value' => "^$"];
            }
            $this->layers[] = (['name' => $domain, 'collectors' => $collectors]);
        }

        $this->writeToFile();
    }

    private function writeToFile() {
        $fileContent = [
            'deptrac' => [
                'layers' => $this->layers,
            ],
        ];
        file_put_contents(
            $this->tempConfigFile,
            yaml_emit($fileContent, YAML_UTF8_ENCODING, 0)
        );
    }
}


$changedFiles = [];
if (!empty($argv[1])) {
    $changedFiles = explode(" ", $argv[1]);
}
$generator = new DeptracConfigGenerator($changedFiles);
$generator->generateConfig();
