<?php

/**
 * This is CountDownWidget class file
 *
 * PHP version 5
 *
 * @category Countdown Widget
 * @package  quexer69/yii-countdown
 * @author   Christopher Stebe <cstebe@iserv4u.com>
 * @license  http://opensource.org/licenses/MIT MIT
 * @version  0.3.0
 * @link     https://github.com/Quexer69/yii-countdown github repository
 *
 */
class CountDownWidget extends CWidget
{

    private static $unique;

    public $year = null;

    public $month = null;

    public $day = null;

    public $hour = 0;

    public $minutes = 0;

    public $seconds = 0;

    public $finished_html = 'finished message (html)';

    public $container_class = null;

    private $total_seconds;

    /**
     * This method provide unique id for each countdown
     *
     * @return string
     */
    public static function getUniqueId()
    {

        return md5(++self::$unique);

    }

    /**
     * Init method.
     */
    public function init()
    {
        $start               = time();
        $end                 = mktime(
            $this->hour,
            $this->minutes,
            $this->seconds,
            $this->month,
            $this->day,
            $this->year
        );
        $this->total_seconds = ((int)$end - (int)$start);

        $script = 'function countDownTimer() {
            $(".countdown").each(function() {
                var value = parseInt($(this).attr(\'value\')) ' . '+' . ' 1;

                if(typeof(value_iniziale) == \'undefined\') {
                    value_iniziale = value;
                }

                $(this).attr(\'value\',value);

                seconds = value;
                _seconds = seconds % 60;
                _minutes = ((seconds - _seconds) / 60) % 60;
                _hours = (seconds - _seconds - _minutes * 60) / 3600;
                _days = _hours / 24;
                _hours = _hours % 24;
                _hours = _hours < 10 ? "0"+_hours : _hours;
                _minutes = _minutes < 10 ?  "0" + _minutes : _minutes;

                _seconds = _seconds < 10 ? "0" + _seconds  : _seconds;
                _seconds = (_seconds == null) ? "<strong>" + _seconds + "</strong> Sekunden ": "";

                var html_output = "<strong>" + parseInt(_days) + "</strong> Tage "
                                + "<strong>" + _hours + "</strong> Stunden "
                                + "<strong>" + _minutes + "</strong> Minuten "
                                + _seconds;

                $("#"+$(this).attr("rel")).html(html_output);

		        if((value + (' . $this->total_seconds . ') >= value_iniziale-1) || (value <= 0)) {

                    $(this).html("' . $this->finished_html . '");
                }
            });
            setTimeout("countDown();", 1000);
        }';

        Yii::app()->getClientScript()
            ->registerCoreScript('jquery')
            ->registerScript('CountDownWidget', $script, CClientScript::POS_END)
            ->registerScript('callCountDownWidget', 'countDownTimer()', CClientScript::POS_END);

    }

    /**
     * Run method.
     *
     * render template view
     */
    public function run()
    {
        $this->render(
            'template',
            array(
                'class'         => $this->container_class,
                'total_seconds' => $this->total_seconds,

            )
        );
    }
}
