Exemple

```
include 'Genrsa.php';
include 'Epmsi.php';

$url = 'http://autoih.localhost/api.php';

$genrsa = new Genrsa($url);
$genrsa
  ->setPeriod('M0')
  ->setYear(2012)
  ->addFile('rss', 'rss.txt')
  ->addFile('autorisations', 'autorisations.txt')
  ->addFile('anohosp', 'anohosp.txt')
  ->launch()
;


$genrsa
  ->waitForStatus(array('SUCCESS', 'FAILURE'))
;

file_put_contents('export_genrsa.zip', $genrsa->getFile('exported_zip'));


$epmsi = new Epmsi($url);
$epmsi
  ->setPeriod('M0')
  ->setYear(2012)
  ->addFile('export_genrsa', 'export_genrsa.zip')
  ->launch()
;

$epmsi
  ->waitForStatus(array('SUCCESS', 'FAILURE'))
;
file_put_contents('export_epmsi.zip', $genrsa->getFile('exported_zip'));
```
