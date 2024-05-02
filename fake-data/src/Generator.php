<?php

namespace FakeData;

use FakeData\Extension\StorageExtension;

/**
 * @method string citySuffix()
 *
 * @method string streetSuffix()
 *
 * @method string buildingNumber()
 *
 * @method string city()
 *
 * @method string streetName()
 *
 * @method string streetAddress()
 *
 * @method string postcode()
 *
 * @method string address()
 *
 * @method string country()
 *
 * @method float latitude($min = -90, $max = 90)
 *
 * @method float longitude($min = -180, $max = 180)
 *
 * @method float[] localCoordinates()
 *
 * @method int randomDigitNotNull()
 *
 * @method mixed passthrough($value)
 *
 * @method string randomLetter()
 *
 * @method string randomAscii()
 *
 * @method array randomElements($array = ['a', 'b', 'c'], $count = 1, $allowDuplicates = false)
 *
 * @method mixed randomElement($array = ['a', 'b', 'c'])
 *
 * @method int|string|null randomKey($array = [])
 *
 * @method array|string shuffle($arg = '')
 *
 * @method array shuffleArray($array = [])
 *
 * @method string shuffleString($string = '', $encoding = 'UTF-8')
 *
 * @method string numerify($string = '###')
 *
 * @method string lexify($string = '????')
 *
 * @method string bothify($string = '## ??')
 *
 * @method string asciify($string = '****')
 *
 * @method string regexify($regex = '')
 *
 * @method string toLower($string = '')
 *
 * @method string toUpper($string = '')
 *
 * @method int biasedNumberBetween($min = 0, $max = 100, $function = 'sqrt')
 *
 * @method string hexColor()
 *
 * @method string safeHexColor()
 *
 * @method array rgbColorAsArray()
 *
 * @method string rgbColor()
 *
 * @method string rgbCssColor()
 *
 * @method string rgbaCssColor()
 *
 * @method string safeColorName()
 *
 * @method string colorName()
 *
 * @method string hslColor()
 *
 * @method array hslColorAsArray()
 *
 * @method string company()
 *
 * @method string companySuffix()
 *
 * @method string jobTitle()
 *
 * @method int unixTime($max = 'now')
 *
 * @method \DateTime dateTime($max = 'now', $timezone = null)
 *
 * @method \DateTime dateTimeAD($max = 'now', $timezone = null)
 *
 * @method string iso8601($max = 'now')
 *
 * @method string date($format = 'Y-m-d', $max = 'now')
 *
 * @method string time($format = 'H:i:s', $max = 'now')
 *
 * @method \DateTime dateTimeBetween($startDate = '-30 years', $endDate = 'now', $timezone = null)
 *
 * @method \DateTime dateTimeInInterval($date = '-30 years', $interval = '+5 days', $timezone = null)
 *
 * @method \DateTime dateTimeThisCentury($max = 'now', $timezone = null)
 *
 * @method \DateTime dateTimeThisDecade($max = 'now', $timezone = null)
 *
 * @method \DateTime dateTimeThisYear($max = 'now', $timezone = null)
 *
 * @method \DateTime dateTimeThisMonth($max = 'now', $timezone = null)
 *
 * @method string amPm($max = 'now')
 *
 * @method string dayOfMonth($max = 'now')
 *
 * @method string dayOfWeek($max = 'now')
 *
 * @method string month($max = 'now')
 *
 * @method string monthName($max = 'now')
 *
 * @method string year($max = 'now')
 *
 * @method string century()
 *
 * @method string timezone($countryCode = null)
 *
 * @method void setDefaultTimezone($timezone = null)
 *
 * @method string getDefaultTimezone()
 *
 * @method string file($sourceDirectory = '/tmp', $targetDirectory = '/tmp', $fullPath = true)
 *
 * @method string randomHtml($maxDepth = 4, $maxWidth = 4)
 *
 * @method string imageUrl($width = 640, $height = 480, $category = null, $randomize = true, $word = null, $gray = false, string $format = 'png')
 *
 * @method string image($dir = null, $width = 640, $height = 480, $category = null, $fullPath = true, $randomize = true, $word = null, $gray = false, string $format = 'png')
 *
 * @method string email()
 *
 * @method string safeEmail()
 *
 * @method string freeEmail()
 *
 * @method string companyEmail()
 *
 * @method string freeEmailDomain()
 *
 * @method string safeEmailDomain()
 *
 * @method string userName()
 *
 * @method string password($minLength = 6, $maxLength = 20)
 *
 * @method string domainName()
 *
 * @method string domainWord()
 *
 * @method string tld()
 *
 * @method string url()
 *
 * @method string slug($nbWords = 6, $variableNbWords = true)
 *
 * @method string ipv4()
 *
 * @method string ipv6()
 *
 * @method string localIpv4()
 *
 * @method string macAddress()
 *
 * @method string word()
 *
 * @method array|string words($nb = 3, $asText = false)
 *
 * @method string sentence($nbWords = 6, $variableNbWords = true)
 *
 * @method array|string sentences($nb = 3, $asText = false)
 *
 * @method string paragraph($nbSentences = 3, $variableNbSentences = true)
 *
 * @method array|string paragraphs($nb = 3, $asText = false)
 *
 * @method string text($maxNbChars = 200)
 *
 * @method bool boolean($chanceOfGettingTrue = 50)
 *
 * @method string md5()
 *
 * @method string sha1()
 *
 * @method string sha256()
 *
 * @method string locale()
 *
 * @method string countryCode()
 *
 * @method string countryISOAlpha3()
 *
 * @method string languageCode()
 *
 * @method string currencyCode()
 *
 * @method string emoji()
 *
 * @method string creditCardType()
 *
 * @method string creditCardNumber($type = null, $formatted = false, $separator = '-')
 *
 * @method \DateTime creditCardExpirationDate($valid = true)
 *
 * @method string creditCardExpirationDateString($valid = true, $expirationDateFormat = null)
 *
 * @method array creditCardDetails($valid = true)
 *
 * @method string iban($countryCode = null, $prefix = '', $length = null)
 *
 * @method string swiftBicNumber()
 *
 * @method string name($gender = null)
 *
 * @method string firstName($gender = null)
 *
 * @method string firstNameMale()
 *
 * @method string firstNameFemale()
 *
 * @method string lastName($gender = null)
 *
 * @method string title($gender = null)
 *
 * @method string titleMale()
 *
 * @method string titleFemale()
 *
 * @method string phoneNumber()
 *
 * @method string e164PhoneNumber()
 *
 * @method int imei()
 *
 * @method string realText($maxNbChars = 200, $indexSize = 2)
 *
 * @method string realTextBetween($minNbChars = 160, $maxNbChars = 200, $indexSize = 2)
 *
 * @method string macProcessor()
 *
 * @method string linuxProcessor()
 *
 * @method string userAgent()
 *
 * @method string chrome()
 *
 * @method string msedge()
 *
 * @method string firefox()
 *
 * @method string safari()
 *
 * @method string opera()
 *
 * @method string internetExplorer()
 *
 * @method string windowsPlatformToken()
 *
 * @method string macPlatformToken()
 *
 * @method string iosMobileToken()
 *
 * @method string linuxPlatformToken()
 *
 * @method string uuid()
 * 
 * @method string mimeType()
 *
 * @method string fileExtension()
 *
 * @method string filePath()
 *
 * @method string bloodType()
 *
 * @method string bloodRh()
 *
 * @method string bloodRh()
 *
 * @method string bloodGroup()
 *
 * @method string ean13()
 *
 * @method string ean8()
 *
 * @method string isbn10()
 *
 * @method string isbn13()
 *
 * @method int numberBetween($int1 = 0, $int2 = 2147483647)
 *
 * @method int randomDigit()
 *
 * @method int randomDigitNot($except)
 *
 * @method int randomDigitNotZero()
 *
 * @method float randomFloat($nbMaxDecimals = null, $min = 0, $max = null)
 *
 * @method int randomNumber($nbDigits = null, $strict = false)
 *
 * @method int semver($preRelease = false, $build = false)
 */

class Generator
{
    protected $providers  = [];
    protected $formatters = [];
    protected $generated  = [];

    public function addProvider($provider)
    {
        array_unshift($this->providers, $provider);

        $this->formatters = [];
    }

    public function getProviders():Array
    {
        return $this->providers;
    }

    public function getGenerated():Array
    {
        return $this->generated;
    }

    public function seed($seed = null):void
    {
        if ($seed === null) {
            mt_srand();
        } else {
            mt_srand((int) $seed, self::mode());
        }
    }

    public function refreshSeed():void
    {
        $new_seed = floor(microtime(true)) + rand();

        $this->seed((int) $new_seed);
    }

    /**
     * @see https://www.php.net/manual/en/migration83.deprecated.php#migration83.deprecated.random
     */
    private static function mode():int
    {
        if (PHP_VERSION_ID < 80300) {
            return MT_RAND_PHP;
        }

        return MT_RAND_MT19937;
    }

    public function format($format, $arguments = []):mixed
    {
        return call_user_func_array($this->getFormatter($format), $arguments);
    }

    /**
     * @param string $format
     *
     * @return callable
     */
    public function getFormatter($format):callable
    {        
        if (isset($this->formatters[$format])) {
            return $this->formatters[$format];
        }

        foreach ($this->providers as $provider) {
            if (method_exists($provider, $format)) {
                $this->formatters[$format] = [$provider, $format];

                return $this->formatters[$format];
            }
        }

        throw new \InvalidArgumentException(sprintf('Unknown format "%s"', $format));
    }

    /**
     * Replaces tokens ('{{ tokenName }}') with the result from the token method call
     *
     * @param string $string String that needs to bet parsed
     *
     * @return string
     */
    public function parse($string):string
    {
        $callback = function ($matches) {
            return $this->format($matches[1]);
        };

        return preg_replace_callback('/{{\s?(\w+|[\w\\\]+->\w+?)\s?}}/u', $callback, $string);
    }

    public function callAnonymous(string $method, Array $attributes = []):mixed
    {
        return $this->format($method, $attributes);
    }

    public function store(StorageExtension $storage, string $collection = null){
        $storage->save($this->generated, $collection);
    }

    /**
     * @param string $method
     * @param array  $attributes
     */
    public function __call($method, $attributes):mixed
    {
        $generated = $this->format($method, $attributes);

        $this->generated[] = $generated;

        return $generated;
    }

    public function __destruct()
    {
        $this->seed();
    }

    public function __wakeup()
    {
        $this->formatters = [];
    }
}
