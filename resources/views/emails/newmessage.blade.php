<h3>Poruka sa sajta:</h3>
<b>Ime i prezime:</b> {{ $content['name'] }} <br><br>
<b>Email:</b> {{ $content['email'] }}<br><br>
<b>Naslov:</b> {{ $content['theme'] }}<br><br>
<b>Poruka:</b><br> {{ nl2br($content['question']) }}