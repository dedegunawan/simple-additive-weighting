<div>
    @includeWhen($isModal, 'livewire.mahasiswa-component.update')
    @includeWhen(!$isModal, 'livewire.mahasiswa-component.index')
</div>


@push('js')
    <script>
        function deleteConfirmation(event, id) {
            event.preventDefault();
            var cf = confirm('Apakah anda yakin akan menghapus data ?');
            if (cf) @this.call('delete', id);
        }
    </script>
@endpush
