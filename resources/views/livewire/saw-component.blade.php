<div>
    <div>
        <h3>Tahap {{$step}} : {{@$stepLists[$step-1]}}</h3>

    </div>
    <div class="card">
        <div class="card-body">
            @if($step > 1)
                <button class="btn btn-primary" wire:click="$set('step', {{$step-1}})">Sebelumnya</button>
            @endif
            @if($step < count($stepLists))
                <button class="btn btn-primary" wire:click="$set('step', {{$step+1}})">Selanjutnya</button>
            @endif
        </div>
    </div>
    @includeWhen($step==1, 'livewire.saw-component.tahap-1')
    @includeWhen($step==2, 'livewire.saw-component.tahap-2')
    @includeWhen($step==3, 'livewire.saw-component.tahap-3')
    @includeWhen($step==4, 'livewire.saw-component.tahap-4')
</div>
