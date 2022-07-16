@can('mortage_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.mortages.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.mortage.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.mortage.title_singular') }} {{ trans('global.list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-userMortages">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.user') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.loandamoutn') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.downpayment') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.percentage') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.loan_terms') }}
                        </th>
                        <th>
                            {{ trans('cruds.mortage.fields.start_date') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mortages as $key => $mortage)
                        <tr data-entry-id="{{ $mortage->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $mortage->id ?? '' }}
                            </td>
                            <td>
                                {{ $mortage->user->name ?? '' }}
                            </td>
                            <td>
                                {{ $mortage->loandamoutn ?? '' }}
                            </td>
                            <td>
                                {{ $mortage->downpayment ?? '' }}
                            </td>
                            <td>
                                {{ $mortage->percentage ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Mortage::LOAN_TERMS_SELECT[$mortage->loan_terms] ?? '' }}
                            </td>
                            <td>
                                {{ $mortage->start_date ?? '' }}
                            </td>
                            <td>
                                @can('mortage_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.mortages.show', $mortage->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('mortage_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.mortages.edit', $mortage->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('mortage_delete')
                                    <form action="{{ route('admin.mortages.destroy', $mortage->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('mortage_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.mortages.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-userMortages:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection