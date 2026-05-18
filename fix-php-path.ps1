# Jalankan sebagai Administrator: klik kanan PowerShell -> Run as administrator
# lalu: Set-ExecutionPolicy Bypass -Scope Process -Force; E:\marketonik2\marketonik2\fix-php-path.ps1

$laragon = "C:\laragon\bin\php\php-8.3.30-Win32-vs16-x64"
$machinePath = [Environment]::GetEnvironmentVariable("Path", "Machine")
$parts = $machinePath -split ';' | Where-Object { $_ -and $_ -ne 'C:\xampp\php' }
$newMachine = ($laragon + ';' + ($parts -join ';')).TrimEnd(';')
[Environment]::SetEnvironmentVariable("Path", $newMachine, "Machine")
Write-Host "PATH sistem diperbarui. Laragon PHP diprioritaskan, XAMPP PHP dihapus dari PATH global."
Write-Host "Tutup semua terminal, lalu buka lagi. Cek dengan: php -v"
