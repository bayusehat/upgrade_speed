<style>
    .right{
        text-align: right;
    }
</style>
<h1 class="h3 mb-2 text-gray-800">REPORT WITEL</h1>
<!-- DataTales Example -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Dapros</h6>
    </div>
    <div class="card-body">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Sukses!</strong> {{ Session::get('success')}}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <br>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> {{ Session::get('error')}}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif
        <div class="table-responsive">
            <table class="table table-bordered table-sm" id="dataTable" width="100%" cellspacing="0">
              <thead>
                <tr>
                    <th>#</th>
                    <th>WITEL</th>
                    <th>DAPROS</th>
                    <th>AGREE</th>
                    <th>BELUM INPUT</th>
                    <th>SUKSES</th>
                    <th>ANOMALI</th>
                    <th>GAGAL</th>
                    <th>ACH</th>
                </tr>
              </thead>
              <tbody>
              </tbody>
              <tfoot>
                  <tr>
                    <th colspan="2" style="text-align:right">Total:</th>
                    <th class="right"></th>
                    <th class="right"></th>
                    <th class="right"></th>
                    <th class="right"></th>
                    <th class="right"></th>
                    <th class="right"></th>
                    <th class="right"></th>
                </tr>
              </tfoot>
            </table>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        loadData()
    });

    function loadData(){
        $('#dataTable').DataTable({
            footerCallback: function ( row, data, start, end, display ) {
                var api = this.api(), data;
    
                var intVal = function ( i ) {
                    return typeof i === 'string' ?
                        i.replace(/[\$,]/g, '')*1 :
                        typeof i === 'number' ?
                            i : 0;
                };
    
                var dapros = api
                    .column( 2 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                var agree = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                var belum_input = api
                    .column( 4 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                var sukses = api
                    .column( 5 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );
                    
                var anomali = api
                    .column( 6 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var gagal = api
                    .column( 7 )
                    .data()
                    .reduce( function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0 );

                var ach_d = api
                    .column(8)
                    .data();

                var sum_ach = 0;
                $.each(ach_d,function(i,val){
                    sum_ach += parseFloat(val);
                });
                var sum_total_ach = sum_ach.toFixed(2);

                $( api.column( 2 ).footer() ).html(numberFormat(dapros));
                $( api.column( 3 ).footer() ).html(numberFormat(agree));
                $( api.column( 4 ).footer() ).html(numberFormat(belum_input));
                $( api.column( 5 ).footer() ).html(numberFormat(sukses));
                $( api.column( 6 ).footer() ).html(numberFormat(anomali));
                $( api.column( 7 ).footer() ).html(numberFormat(gagal));
                $( api.column( 8 ).footer() ).html(sum_total_ach+'%');
            },
            asynchronous: true,
            processing: true, 
            destroy: true,
            ajax: {
                url: "{{ url('load_report') }}",
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: 'GET'
            },
            columns: [
                { name: 'id', searchable: false, orderable: true, className: 'text-center' },
                { name: 'witel'},
                { name: 'dapros', className: 'right'},
                { name: 'agree', className: 'right'},
                { name: 'belum_input', className: 'right'},
                { name: 'sukses', className: 'right'},
                { name: 'anomali', className: 'right'},
                { name: 'gagal', className: 'right'},
                { name: 'ach',className : 'right'}
            ],
            order: [[0, 'asc']],
            iDisplayInLength: 20,
            pageLength: 50,
        });
    }

    function numberFormat(nStr) {
            nStr += '';
            x = nStr.split(',');
            x1 = x[0];
            x2 = x.length > 1 ? '.' + x[1] : '';
            var rgx = /(\d+)(\d{3})/;
            while (rgx.test(x1)) {
              x1 = x1.replace(rgx, '$1' + ',' + '$2');
            }
            return x1 + x2;
        }
</script>