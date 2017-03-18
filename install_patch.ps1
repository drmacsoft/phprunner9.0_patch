Copy-Item -force "source\connections\*" "..\source\connections\"
Copy-Item -force "source\include\*" "..\source\include\"
Copy-Item -force "source\files.txt" "..\source\files.txt"
Copy-Item -force "jalaliCalendar" "..\source\" -recurse
$docfolder=[Environment]::GetFolderPath("MyDocuments")
Copy-Item -force "PHPRunnerPlugins" $docfolder -recurse

