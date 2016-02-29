@extends($admin->getView('index', 'admin'))

@section('grid')
    {{--<form method="POST" id="search-form" class="form-inline" role="form">--}}
        {{--<div class="form-group">--}}
            {{--<label for="name">Name</label>--}}
            {{--<input type="text" class="form-control" name="name" id="name" placeholder="search name">--}}
        {{--</div>--}}
        {{--<div class="form-group">--}}
            {{--<label for="email"># of Post</label>--}}
            {{--<select name="operator" id="operator" class="form-control">--}}
                {{--<option value=">=">&gt=</option>--}}
                {{--<option value="=">=</option>--}}
                {{--<option value=">">&gt</option>--}}
                {{--<option value="<">&lt</option>--}}
            {{--</select>--}}
            {{--<input type="number" class="form-control" name="post" id="post">--}}
        {{--</div>--}}

        {{--<button type="submit" class="btn btn-primary">Search</button>--}}
    {{--</form>--}}
    {{--<input type="text" name="perform_date" id="perform-date-filter">--}}

    @parent
@stop

@section('scripts')
    @parent

    <link rel="stylesheet" type="text/css" href="{{ URL::asset('custom/css/bootstrap-datetimepicker.css') }}">
    <script type="text/javascript" src={{ URL::asset('custom/js/moment.min.js') }}></script>
    <script type="text/javascript" src={{ URL::asset('custom/js/bootstrap-datetimepicker.min.js') }}></script>
    {{--<script type="text/javascript" src="//cdn.datatables.net/plug-ins/1.10.11/filtering/row-based/range_dates.js"></script>--}}

    <script type="text/javascript">
        $(document).ready(function() {
//            $.fn.dataTableExt.afnFiltering.push(
//                function (oSettings, aData, iDataIndex) {
//                    var iFini = document.getElementById('name').value;
//                    var iFfin = document.getElementById('name').value;
//                    var iStartDateCol = 6;
//                    var iEndDateCol = 7;
//
//                    iFini = iFini.substring(6, 10) + iFini.substring(3, 5) + iFini.substring(0, 2);
//                    iFfin = iFfin.substring(6, 10) + iFfin.substring(3, 5) + iFfin.substring(0, 2);
//
//                    var datofini = aData[iStartDateCol].substring(6, 10) + aData[iStartDateCol].substring(3, 5) + aData[iStartDateCol].substring(0, 2);
//                    var datoffin = aData[iEndDateCol].substring(6, 10) + aData[iEndDateCol].substring(3, 5) + aData[iEndDateCol].substring(0, 2);
//
//                    if (iFini === "" && iFfin === "") {
//                        return true;
//                    }
//                    else if (iFini <= datofini && iFfin === "") {
//                        return true;
//                    }
//                    else if (iFfin >= datoffin && iFini === "") {
//                        return true;
//                    }
//                    else if (iFini <= datofini && iFfin >= datoffin) {
//                        return true;
//                    }
//                    return false;
//                }
//            );

//            var oTable = window.LaravelDataTables.dataTableBuilder;
//            console.log(oTable.ajax);
//            oTable.ajax = function (data, callback, settings) {
//                data.name = $('input[name=name]').val();
//                data.operator = $('select[name=operator]').val();
//                data.post = $('input[name=post]').val();
//
//                callback(data);
//            };
////            oTable.ajax.reload();
//
//            $('#search-form').on('submit', function(e) {
//                oTable.draw();
//
//                return false;
//            });

            /* Add event listeners to the two range filtering inputs */
//            $('#name').keyup( function() { oTable.draw(); } );
        });
    </script>
@stop
