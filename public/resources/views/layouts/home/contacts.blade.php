<div class="card calendar-card-dei no-border ">
    <div class="card-body no-padding contactos ">
        <p class="card-title card-title-dei" style="max-width: 20rem">{{ __('static.home.secondary.title') }}</p>
        @php
            $contactNumber = 7;
            $contacts = [];
            for ($i=0; $i < $contactNumber; $i++) { 
                $contact;
                if(__('static.home.secondary.contacts.' . $i.'.name' != ''))
                    $contact['name'] = __('static.home.secondary.contacts.' . $i.'.name');
                $contact['job'] = __('static.home.secondary.contacts.' . $i.'.job');
                $contact['email'] = __('static.home.secondary.contacts.' . $i.'.email');
                $contact['phone'] = __('static.home.secondary.contacts.' . $i.'.tel');
                $contact['phone2'] = __('static.home.secondary.contacts.' . $i.'.tel2');
                $contacts[] = $contact;
            }
        @endphp
        @foreach ($contacts as $contact)
        {{-- Márcia do Espírito Santo<br>
            Secretariado dos Cursos<br></span> --}}
        <p class="contact ">
            <span class="fw-400 ">
                @if($contact['job'] != '')
                {{$contact['job']}}<br>
                @endif
                @if($contact['name']  != '')
                {{$contact['name']}}<br>
                @endif
            </span>
            <a href="mailto: {{$contact['email']}}" class="card-link">{{$contact['email']}}</a><br>
            @if($contact['phone']!='' || $contact['phone2']!='')
                Tel: {{$contact['phone']}}<br>
                Tel2: {{$contact['phone2']}}<br>
            @endif
        </p>
        @endforeach
        {{-- <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="card-link">Card link</a>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="card-link">Card link</a>
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
      <a href="#" class="card-link">Card link</a> --}}
    </div>
</div>