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
 * @version  0.1.0
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

    public $follow = null;

    public $up = false;

    public $container_class = null;

    public $total_seconds = 0;

    /**
     * This method provide unique id for each countdown
     *
     * @return string
     */
    public function getUniqueId()
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
            $this->seconds,
            $this->minutes,
            $this->hour,
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

                secondi = value;
                _secondi = secondi % 60;
                _minuti = ((secondi - _secondi) / 60) % 60;
                _ore = (secondi - _secondi - _minuti * 60) / 3600;
                _days = _ore / 24;
                _ore = _ore % 24;
                _ore = _ore < 10 ? "0"+_ore : _ore;
                _minuti = _minuti < 10 ?  "0" + _minuti : _minuti;

                _secondi = _secondi < 10 ? "0" + _secondi  : _secondi;
                _secondi = (_secondi == null) ? "<strong>" + _secondi + "</strong> Sekunden ": "";

                var html_output = "<strong>" + parseInt(_days) + "</strong> Tage "
                                + "<strong>" + _ore + "</strong> Stunden "
                                + "<strong>" + _minuti + "</strong> Minuten "
                                + _secondi;

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
                'this' => $this
            )
        );
    }
}
