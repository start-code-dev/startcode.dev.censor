censor
======

## Install
Via Composer

```sh
composer require startcode/censor
```

## Usage
$bannedWords = ['very', 'bad'];
<br>
<br>
$aCensor = (new Censor($bannedWords))
<br>
&nbsp;&nbsp;&nbsp;&nbsp;    ->setCensorMark('*')
<br>
&nbsp;&nbsp;&nbsp;&nbsp;    ->censor('some very bad string');
<br>
<br>
$aCensor->getOriginalString(); // 'some very bad string'
<br>
$aCensor->getCleanedString(); // 'some **** *** string'
<br>
$aCensor->getForbiddenMatches(); // ['very', 'bad']
<br>
$aCensor->isCensoredString(); // true


## Development

### Install dependencies

    $ composer install

### Run tests

    $ make unit-tests

## License

(The MIT License)
see LICENSE file for details...
