@extends('layouts.master')
@section('content')
@can('mortage_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.mortages.create') }}">
                {{ trans('Add Mortgage') }}
            </a>
            <a class="btn btn-success" style="float: right;" href="{{ route('admin.complete_mortage_report') }}">
                {{ trans('Report') }}
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
            <table class=" table table-bordered table-striped table-hover datatable datatable-Mortage">
                <thead>
                    <tr> 
                       
                        <th>
                            {{ trans('cruds.mortage.fields.id') }}
                        </th>
                        <th>
                             {{ trans('Customer') }}
                        </th>
                        <th>
                            {{ trans('Loan Amount') }}
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
                        {{ trans('Operation') }}
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($mortages as $key => $mortage)
                        <tr data-entry-id="{{ $mortage->id }}">
      
                            <td>
                                {{ $mortage->id ?? '' }}
                            </td>
                            <td>
                                {{ $mortage->user->name ?? '' }}
                            </td>
                            
                        <td>${{number_format ( $mortage->loandamoutn, 2, ".", "," ) ?? ''}}</td>
                        <td>${{number_format ( $mortage->downpayment, 2, ".", "," ) ?? ''}}</td>
                           
                            <td>
                                {{ $mortage->percentage ?? '' }} &nbsp%
                            </td>
                            <td>
                                {{ $mortage->loan_terms ?? '' }} &nbspyear
                            </td>
                            <td>
                                {{ $mortage->start_date ?? '' }}
                            </td>
                            <td>
                                @can('mortage_delete')
                                    <form action="{{ route('admin.mortages.destroy', $mortage->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan
                                <a href="{{ route('admin.summary',[$mortage->id])}}"><button type="submit" class="btn btn-xs btn-dark mt-1 " >Summary</button></a>
                                <a href="report/{{$mortage->id}}"><button  class="btn btn-xs btn-dark mt-1 " >Report</button></a>

                            </td>  

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
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
  let table = $('.datatable-Mortage:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
