<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Class Event - Helper class to build events for the calendar
 * This class gathers start and end date of an event. 
 * @package App\Helpers
 * @version 1.0.0
 * @author Me
 */

class Event
{
    protected string $startDate;
    protected string $endDate;
    protected string $title;
    protected string $subtitle;
    protected string $description;
    protected string $link;

    private $startMonth;
    private $endMonth;
    private $startYear;
    private $endYear;
    private $startDay;
    private $endDay;
    private $yeargap;
    private $currentYear;
    private $linkText;
    /**
     * Event constructor.
     * @param string $startDate
     * @param string $endDate
     * @param string $title
     * @param string $subtitle
     * @param string $description
     * @param string $link
     * @param string $linkText
     */
    public function __construct(string $startDate = '', string $endDate = '', string $title = '', string $subtitle = '', string $description = '', string $link = '', string $linkText = '')
    {
        //if any of them null, set to ''
        $this->startDate = $startDate ?? '';
        $this->endDate = $endDate ?? '';
        $this->title = $title ?? '';
        $this->subtitle = $subtitle ?? '';
        $this->description = $description ?? '';
        $this->link = $link ?? '';
        $this->linkText = $linkText ?? '';

        $this->startMonth = Carbon::parse($this->startDate)->isoFormat('MMMM');
        $this->endMonth = Carbon::parse($this->endDate)->isoFormat('MMMM');
        $this->startYear = Carbon::parse($this->startDate)->isoFormat('Y');
        $this->endYear = Carbon::parse($this->endDate)->isoFormat('Y');
        //if app locale in english use the day number with the suffix
        if (app()->getLocale() === 'en') {
            $this->startDay = Carbon::parse($this->startDate)->isoFormat('Do');
            $this->endDay = Carbon::parse($this->endDate)->isoFormat('Do');
        } else {
            //if app locale is not english use the day number without the suffix
            $this->startDay = Carbon::parse($this->startDate)->isoFormat('D');
            $this->endDay = Carbon::parse($this->endDate)->isoFormat('D');
        }
        $this->yeargap = $this->endYear - $this->startYear;
        $this->currentYear = Carbon::now()->isoFormat('Y');

    }

    /**
     * Returns the event in a readable format.
     * If the event has a start and end date, and should it be on the same month, the event should be displayed as a range of dates wihtout repeating the month. "From 1st to 4th of January"
     * If the event has a start and end date, and should it be on different months, the event should be displayed as a range of dates with the month repeated. "From 1st of January to 4th of February"
     * If the event is a single day event, the start and end date will be the same. "January 12th"
     * If there is no end date, the end date will be the same as the start date. And the event should be displayed as an event starting at that start date. "From 1st of January"
     * If there is no start date but there is an end date the event should be displayed as an event ending at that end date. Such as a deadline. "Until 4th of January"
     * If the year gap between the start and end date is greater than 2, the year should be displayed. "From 1st of January 2021 to 4th of January 2022"
     * @return string $readableDate
     */
    public function event(): string
    {
        $readableDate = "";


        //if the currentYear is different from start year, add the year to the start date "From 1st of January 2021 to 4th of January [2022]"

        //check if start date is before end date
        if ($this->startDate && $this->endDate && Carbon::parse($this->startDate)->gt(Carbon::parse($this->endDate))) {
            $readableDate = __('messages.date.invalid');
        } elseif ($this->currentYear === $this->startYear) {
            $readableDate = $this->caseSameStartyearAsCurrent();
        } else {
            $readableDate = $this->caseDifferentStartyearAsCurrent();
        }





        return $readableDate;
    }

    private function caseSameStartyearAsCurrent(): string
    {
        $readableDate = "";
        //if both dates exist
        if ($this->startDate && $this->endDate) {
            // if both dates are the same day
            if ($this->startDay === $this->endDay)
                $readableDate = /* __('words.on') . ' ' .  */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth;
            //if same month different days
            elseif ($this->startMonth === $this->endMonth) {
                //year gap is 0
                if ($this->yeargap === 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->startMonth;
                //year gap is 1
                elseif ($this->yeargap > 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth . ' ' . $this->endYear;
                //if different months
            } elseif ($this->startMonth !== $this->endMonth) {

                //year gap is 0
                if ($this->yeargap === 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth;
                //year gap is 1
                elseif ($this->yeargap > 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth . ' ' . $this->endYear;
            }
        } 
        //if only start date exists
        elseif ($this->startDate && !$this->endDate) {
            $readableDate = __('words.from') . ' ' . $this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth;
        } 
        //if only end date exists
        elseif (!$this->startDate && $this->endDate) {
            //if end date is of current year
            if ($this->endYear === $this->currentYear)
                $readableDate = __('words.until') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth;
            //if end date is of other year
            else $readableDate = __('words.until') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth . ' ' . $this->endYear;
        } else {
            $readableDate = __('messages.date.none');
        }
        return $readableDate;
    }
    private function caseDifferentStartyearAsCurrent(): string
    {
        $readableDate = "";
        //if both dates exist
        if ($this->startDate && $this->endDate) {
            // if both dates are the same day
            if ($this->startDay === $this->endDay)
                $readableDate = /* __('words.on') . ' ' .  */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . $this->startYear;
            //if same month different days
            elseif ($this->startMonth === $this->endMonth) {
                //year gap is 0
                if ($this->yeargap === 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . $this->startYear;
                //year gap is 1
                elseif ($this->yeargap > 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . $this->startYear . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth . ' ' . $this->endYear;
            } elseif ($this->startMonth !== $this->endMonth) {
                //year gap is 0
                if ($this->yeargap === 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . $this->startYear . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth . ' ' . $this->endYear;
                //year gap is 1
                elseif ($this->yeargap > 0)
                    $readableDate = /*__('words.from') . ' ' . */$this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . $this->startYear . ' ' . __('words.to') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth . ' ' . $this->endYear;
            }
       
        } 
        //if only start date exists
        elseif ($this->startDate && !$this->endDate) {
            $readableDate = __('words.from') . ' ' . $this->startDay . ' ' . __('words.of') . ' ' . $this->startMonth . ' ' . $this->startYear;
        }
        //if only end date exists
        elseif (!$this->startDate && $this->endDate) {
            //if end date is of current year
            if ($this->endYear === $this->currentYear)
                $readableDate = __('words.until') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth;
            //if end date is of other year
            else $readableDate = __('words.until') . ' ' . $this->endDay . ' ' . __('words.of') . ' ' . $this->endMonth . ' ' . $this->endYear;
        } else {
            $readableDate = __('messages.date.none');
        }
        return $readableDate;
    }

    public function eventAsDateString(){
        if ($this->startDate && $this->endDate && Carbon::parse($this->startDate)->gt(Carbon::parse($this->endDate))) {
            return __('messages.date.invalid');
        } elseif($this->startDate && $this->endDate){
            return Carbon::parse($this->startDate)->toDateString() . ' ' . __('words.to') . ' ' . Carbon::parse($this->endDate)->toDateString();
        }elseif($this->startDate && !$this->endDate){
            return __('words.from') . ' ' . Carbon::parse($this->startDate)->toDateString();
        }elseif(!$this->startDate && $this->endDate){
            return __('words.until') . ' ' . Carbon::parse($this->endDate)->toDateString();
        }else{
            return __('messages.date.none');
        }
    }

    /**
     * toString
     */
    public function __toString(): string
    {
        return $this->event();
    }

    /**
     * @return string
     */
    public function getLink(): string
    {
        return $this->link;
    }

    /**
     * @param string $link 
     * @return self
     */
    public function setLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description 
     * @return self
     */
    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title 
     * @return self
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;
        return $this;
    }

	/**
	 * @return mixed
	 */
	public function getLinkText() {
		return $this->linkText;
	}
	
	/**
	 * @param mixed $linkText 
	 * @return self
	 */
	public function setLinkText($linkText): self {
		$this->linkText = $linkText;
		return $this;
	}
}