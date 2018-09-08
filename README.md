# pastebin-api

Smart usage: 
```
$pastebinApi  = new PastebinApi('YOUR_DEV_KEY);

$url = $pastebinApi->createPaste('paste_code');

$url = $pastebinApi->getPasteList('USER_CODE');

$url = $pastebinApi->deletePaste('USER_CODE','API_PAST_CODE');

$url = $pastebinApi->getPastesRaw('USER_CODE','API_PAST_CODE');
```

Method `сreatePaste`  has additional params, look at method type hinting  for detail, and [pastenbin](https://pastebin.com/api)
 