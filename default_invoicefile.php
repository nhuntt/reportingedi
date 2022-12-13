<?php 

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
$content=fwrite($myfile, $txt);
fclose($myfile);
//------------------------------------------
chdir("./../../");
$dir = getcwd();
echo $dir."<br>";
chdir('domains');
chdir('edisolution.online');
$dir2 = getcwd();
echo $dir2."<br>";
chdir("Outbox");
$dir3 = getcwd();
echo $dir3."<br>";

$myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
$txt = "John Doe\n";
fwrite($myfile, $txt);
$txt = "Jane Doe\n";
$content=fwrite($myfile, $txt);
fclose($myfile);

file_put_contents('newfile.txt',$content);
// chdir("./../");
// chdir('public_html');
//$dir3 = getcwd();
//echo $dir3."<br>";
//unlink('newfile.txt');
?>