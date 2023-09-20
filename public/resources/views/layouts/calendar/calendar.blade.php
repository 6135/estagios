@if ($calendar)
    <div class="card calendar-card-dei no-border ">
        <div class="card-body no-padding contactos ">
            <p class="card-title card-title-with-subtitle">{{ $calendar->getTitle() }}</p>
            <p class="card-subtitle"> {{ $calendar->getSubtitle() }}</p>
            @foreach ($calendar->getColumns() as $column)
                <div class="container-fluid row fs-5">
                    @foreach ($column as $event)
                        <div class="col-md-{{ $calendar->getSizeOfBootstrapColumns() }}"
                            style='padding-left: 0; margin-bottom: 0.9rem'>
                            <div class="card-body no-padding contactos ">
                                <p class="card-title card-title-with-subtitle fwd-600 text-primary"
                                    style="font-size: var(--font-size-base); line-height: normal; @if ($event->getLink() === '') margin-bottom: 5px @endif">
                                    {{ $event }}</p>
                                @if ($event->getLink() !== '')
                                    <a href="{{ $event->getLink() }}" class="fwd-600"
                                        style="font-size: var(--font-size-base); margin-top: -10px">
                                        <p>{{ $event->getLinkText() }}</p>
                                    </a>
                                @endif
                                <p class="card-subtitle fwd-400"
                                    style="font-size: var(--font-size-base); line-height: normal; margin-bottom: 0">
                                    {{ $event->getDescription() }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
    </div>
    </div>
@endif
