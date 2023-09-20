<?php

namespace App\Helpers;

use App\EstagioPeriodo;
use App\Models\EdicaoEstagio;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;

/**
 * Class CalendarBuilder - Helper class to build calendar for the front-end
 * @package App\Helpers
 * @version 1.0.0
 * @author Me
 * 
 * 
 * Possibly 3 columns for mobile.
 */
class CalendarBuilder
{
    protected string $title;
    protected string $subtitle;
    protected string $description;
    /*TODO: get dates from edicao estagio and use those
        nomes para as edições de estágio:
        Mestrado em Engenharia Informática (Plurianual Fev 2023 - Fev 2024)
        Mestrado em Engenharia Informática (Set 2023 - Julho 2024)
        Mestrado em Segurança Informática (Set 2023 - Julho 2024) 
        Mestrado em Engenharia e Ciência de Dados (Set 2023 - Julho 2024)
        Mestrado em Design e Multimédia (Set 2023 - Julho 2024)
        Curso Não Conferente de Grau Acertar o Rumo (faltam datas)
        */
    /**
     * @var int -1 means automatic mode, 0 means single column, 1 means double forced double column if number of events is greater than columnThreshold or if the number of events is greater than 2.
     */
    protected int $doubleColumn;

    /**
     * @var int represents the number of events that will trigger a double column in automatic mode or if doubleColumn is set to 1, default is 6 (3 per column)
     */
    protected int $columnThreshold;

    /**
     * If set, will force the number of columns to be this number, overrides doubleColumn and columnThreshold
     * @var int number of columns 
     */
    protected int $numberOfColumns;
    protected array $events;
    private array $columns;
    private int $numberOfEvents;

    /**
     * CalendarBuilder constructor.
     * @param string $title
     * @param string $subtitle
     * @param string $description
     * @param array $events
     */
    public function __construct(string $title, string $subtitle, string $description, array $events, int $columnThreshold = 6, int $doubleColumn = -1, int $numberOfColumns = 2)
    {
        $this->title = $title;
        $this->subtitle = $subtitle;
        $this->description = $description;
        $this->events = $events;
        $this->numberOfEvents = count($events);
        $this->doubleColumn = $doubleColumn;
        $this->columnThreshold = $columnThreshold;
        $this->numberOfColumns = $numberOfColumns;
        //if in auto mode, check if we need to do double column
        if ($this->doubleColumn === -1 && $numberOfColumns==2) {
            if ($this->numberOfEvents > $this->columnThreshold && $this->numberOfEvents > 1) {
                $this->doubleColumn = 1;
            } else {
                $this->doubleColumn = 0;
            }
            $this->numberOfColumns = 2;
        } else if($numberOfColumns!=2) {
            $this->doubleColumn = 1;
            $this->columnThreshold = 1;
            $this->numberOfColumns = $numberOfColumns;
        }

        $this->buildColumns();

    }

    private function buildColumns()
    {
        $this->columns = [];

        //split events into columns
        if ($this->doubleColumn === 1) {
            $this->columns = array_chunk($this->events, ceil($this->numberOfEvents / $this->numberOfColumns));
        } else {
            $this->columns[] = $this->events;
        }

    }

    public static function buildEventsFromPeriodoEstagio(EdicaoEstagio $periodoEstagio): array
    {

        return [
            new Event(
                startDate:      $periodoEstagio->datainicio,
                endDate:        $periodoEstagio->datafim,
                title:          __('messages.calendar.proposals.submission.title'),
                description:    __('messages.calendar.proposals.submission.description'),
            ),
            new Event(
                // startDate:      "2023-06-02", 
                endDate:        "2023-06-02",
                title:          __('messages.calendar.proposals.eval.title'),
                description:    __('messages.calendar.proposals.eval.description'),
            ),
            new Event(
                startDate:      "2023-06-03",
                endDate:        "2023-06-12",
                title:          __('messages.calendar.proposals.review.title'),
                description:    __('messages.calendar.proposals.review.description'),
            ),new Event(
                startDate:     '2023-06-19',
                endDate:        "2023-06-19",
                title:          __('messages.calendar.proposals.publication.title'),
                description:    __('messages.calendar.proposals.publication.description'),
            ),
            new Event(
                startDate:     '2023-06-21',
                endDate:        "2023-06-21",
                title:          __('messages.calendar.proposals.dayInter.title'),
                link:           'https://estagios.dei.uc.pt/dia-das-empresas/',
                linkText:       __('messages.calendar.proposals.dayInter.description')
            ),
            new Event(
                startDate:     $periodoEstagio->datainicioalunos,
                endDate:        $periodoEstagio->datafimalunos,
                title:          __('messages.calendar.proposals.candidacy.title'),
                description:    __('messages.calendar.proposals.candidacy.description'),   
            ),
            new Event(
                startDate:     $periodoEstagio->datafimalunos,
                endDate:        $periodoEstagio->datafim_perfilaluno,
                title:          __('messages.calendar.proposals.interview.title'),
                description:    __('messages.calendar.proposals.interview.description'),
            ),
            new Event(
                startDate:      Carbon::parse($periodoEstagio->datafim_perfilaluno)->addDay()->toString(),
                endDate:        '2023-07-14',
                title:          __('messages.calendar.proposals.selection.title'),
                description:    __('messages.calendar.proposals.selection.description'),
            ),       
            new Event(
                startDate:      '2023-07-15',
                endDate:        '2023-07-15',
                title:          __('messages.calendar.proposals.selection.publication.title'),
                description:    __('messages.calendar.proposals.selection.publication.description'),
            ),     
            new Event(
                startDate:      '2023-07-15',
                endDate:        '2023-07-18',
                title:          __('messages.calendar.proposals.selection.publication.complaints.title'),
                description:    __('messages.calendar.proposals.selection.publication.complaints.description'),
            ),

            new Event(
                startDate:      $periodoEstagio->show_estagio_atrib_alunos,
                endDate:        $periodoEstagio->show_estagio_atrib_alunos,
                title:          __('messages.calendar.proposals.selection.publication.final.title'),
                description:    __('messages.calendar.proposals.selection.publication.final.description'),
            ),

        ];

    }
    /**
     * @return string
     */
    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    /**
     * @param string $subtitle 
     * @return self
     */
    public function setSubtitle(string $subtitle): self
    {
        $this->subtitle = $subtitle;
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
     * 
     * @return int
     */
    public function getDoubleColumn(): int
    {
        return $this->doubleColumn;
    }

    /**
     * 
     * @param int $doubleColumn 
     * @return self
     */
    public function setDoubleColumn(int $doubleColumn): self
    {
        $this->doubleColumn = $doubleColumn;
        //rebuilt columns
        $this->buildColumns();
        return $this;
    }

    /**
     * @return array
     */
    public function getColumns(): array
    {
        return $this->columns;
    }

    /**
     * @param array $columns 
     * @return self
     */
    public function setColumns(array $columns): self
    {
        $this->columns = $columns;
        return $this;
    }
    
    public function getNumberOfEvents(): int
    {
        return $this->numberOfEvents;
    }

    public function getNumberOfColumns(): int
    {
        return count($this->columns);
    }

    public function getSizeOfBootstrapColumns(): int
    {
        return 12 / $this->getNumberOfColumns();
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
     * @return array
     */
    public function getEvents(): array
    {
        return $this->events;
    }

    /**
     * @param array $events 
     * @return self
     */
    public function setEvents(array $events): self
    {
        $this->events = $events;
        $this->buildColumns();
        return $this;
    }

    /**
     * @return int
     */
    public function getColumnThreshold(): int
    {
        return $this->columnThreshold;
    }

    /**
     * @param int $columnThreshold 
     * @return self
     */

    public function setColumnThreshold(int $columnThreshold): self
    {
        $this->columnThreshold = $columnThreshold;
        return $this;
    }

    //get each column by index
    public function getColumn(int $index): array
    {
        return $this->columns[$index];
    }

    

}