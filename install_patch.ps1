Copy-Item -force "source\connections\*" "..\source\connections\"
Copy-Item -force "source\include\*" "..\source\include\"
Copy-Item -force "source\files.txt" "..\source\files.txt"
Copy-Item -force "jalaliCalendar" "..\source\" -recurse

#copy plugins to User Document Directory
$docfolder=[Environment]::GetFolderPath("MyDocuments")
Copy-Item -force "PHPRunnerPlugins" $docfolder -recurse


Copy-Item -force "fix_expiration.ps1" "..\source\fix_expiration.ps1"

