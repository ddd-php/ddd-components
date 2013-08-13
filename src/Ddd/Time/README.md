TimeMachine
===========

Installation
------------

Using Composer, just require the `ddd/time` package:

``` javascript
{
    "require": {
        "ddd/time": "dev-master"
    }
}
```

Howtos
------

```
TimeMachine\Time\Tests\HowTo\DateInterval
 [x] How to get number of days between 2 dates
 [ ] How to get number of hours between 2 dates
 [ ] How to get number of minutes between 2 dates
 [ ] How to get number of seconds between 2 dates
 [x] How to get each day between 2 dates
 [x] How to know if a date interval is before after during other date interval
 [ ] How to know if a date interval is before after during a given date
 [ ] How to know if a date interval is before after during a given time interval
 [ ] How to know if a date interval is before after during a given time point
 [ ] How to tranform date interval into time interval

TimeMachine\Time\Tests\HowTo\Date
 [x] How to create a date only
 [x] How to come back at begin of current week
 [x] How to know if a date is after before equal to an other
 [x] How to convert a ddd time date object into regular date time object
 [x] How to know if date is during weekend or weekday
 [x] How to get previous next date
 [x] How to add remove a duration from it can return date or time point
 [x] How to transform a date into a time point
 [x] How to know diff between it and an other date
 [ ] How to know diff between it and a time point

TimeMachine\Time\Tests\HowTo\Duration
 [ ] How to know how long x days in hours minutes seconds
 [ ] How to know how long x weeks in days hours minutes seconds
 [ ] How to know how long x months in weeks days hours minutes seconds
 [ ] How to know how long x years in months weeks days hours minutes seconds
 [ ] How to know how long x centuries in years months weeks days hours minutes seconds
 [ ] How to know how long a years b months c weeks d days in hours minutes seconds

TimeMachine\Time\Tests\HowTo\TimeInterval
 [ ] How to know if a time interval is before after during an other time interval
 [ ] How to know if a time interval is before after during a given date interval
 [ ] How to know if a time interval is before after during a given date
 [ ] How to know if a time interval is before after during a given date time
 [ ] How to transform a time interval into a date interval destroy data
 [ ] How to know how long a time interval are in at least seconds minutes hours days weeks years

TimeMachine\Time\Tests\HowTo\TimeOfDay
 [x] How to know if a time of day is before after equal an other time of day
 [x] How to know if it is the ante meridian post meridian

TimeMachine\Time\Tests\HowTo\TimePoint
 [x] How to know if it is before after equal an other time point
 [x] How to know if it is before after equal a given date
 [x] How to know if it is before after during a given date interval
 [ ] How to know if a it is bbefore after equal a given time interval
 [ ] How to know if it is during night or daylight
 [x] How to add remove duration from it
 [x] How to convert a ddd time point object into regular date timeobject

```

Inspired by: http://timeandmoney.sourceforge.net/timealgebra.html
