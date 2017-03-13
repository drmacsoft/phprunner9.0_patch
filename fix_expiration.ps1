$configFiles = Get-ChildItem output\templates\ *.htm
foreach ($file in $configFiles)
{
    $rrr = Get-Content $file.PSPath -Raw
    ($rrr -replace "html>(.|\n)*<HT", 'html><HT$1') |
    Set-Content $file.PSPath
}

Get-Content "output\classes\runnerpage.php" | Where-Object {$_ -notmatch 'jquery\.mCustomScrollbar\.min\.js'} | Set-Content "output\classes\runnerpage2.php"
Move-Item  -force "output\classes\runnerpage2.php" "output\classes\runnerpage.php"