require('./bootstrap');

import DataTable from 'datatables.net-dt';
import 'datatables.net-select-dt/js/select.dataTables.min.js'
import 'datatables.net-select-dt/css/select.dataTables.min.css'
import 'datatables.net-dt/css/jquery.dataTables.min.css'
new DataTable('#myTable', {
    select: 'single'
});
