Add-Type -AssemblyName System.IO.Compression
Add-Type -AssemblyName System.IO.Compression.FileSystem

$project = "D:\Project\alvin_agachi\it_support_dashboard"
$output  = "D:\Project\it_support_dashboard_FINAL.zip"

$excludeFolders = @(
    ".git",
    ".vscode",
    "node_modules",
    "tests"
)

$excludeFiles = @(
    ".env",
    "buat_zip_benar.ps1"
)

if (Test-Path $output) {
    Remove-Item $output -Force
}

$fileStream = [System.IO.File]::Open(
    $output,
    [System.IO.FileMode]::Create
)

$archive = New-Object System.IO.Compression.ZipArchive(
    $fileStream,
    [System.IO.Compression.ZipArchiveMode]::Create
)

try {
    Get-ChildItem -Path $project -Recurse -File | ForEach-Object {
        $file = $_

        $relative = $file.FullName.Substring($project.Length + 1)

        $parts = $relative -split '[\\/]'

        $skipFolder = $false

        foreach ($part in $parts) {
            if ($excludeFolders -contains $part) {
                $skipFolder = $true
                break
            }
        }

        if ($skipFolder) {
            return
        }

        if ($excludeFiles -contains $file.Name) {
            return
        }

        $entryName = $relative.Replace('\', '/')

        [System.IO.Compression.ZipFileExtensions]::CreateEntryFromFile(
            $archive,
            $file.FullName,
            $entryName,
            [System.IO.Compression.CompressionLevel]::Optimal
        ) | Out-Null
    }
}
finally {
    $archive.Dispose()
    $fileStream.Dispose()
}

Write-Host ""
Write-Host "ZIP BERHASIL DIBUAT:"
Write-Host $output
Write-Host ""

$size = (Get-Item $output).Length / 1MB
Write-Host ("Ukuran: {0:N2} MB" -f $size)