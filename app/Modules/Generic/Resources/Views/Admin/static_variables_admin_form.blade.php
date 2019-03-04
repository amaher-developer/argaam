@extends('generic::layouts.form')
@section('breadcrumb')
    <ul class="page-breadcrumb breadcrumb">
    <li>
        <a href="{{ url('/operate') }}">Dashboard</a>
    <i class="fa fa-circle"></i>
    </li>
    <li>
        <a href="{{ route('staticVariables') }}">{{ $title }}</a>
    </li>
    </ul>
@endsection
@section('form_title') {{ @$title }} @endsection
@section('sub_styles')

@endsection
@section('page_body')
    {{--<button onclick="addRow(); return false;" class="btn dark btn-outline add_field_button" >Add New Row</button><br/><br/>--}}

    <form action="{{route('staticVariables')}}" method="post" enctype='multipart/form-data' id="settings_form">
        {{ csrf_field() }}
        <div class="tab-pane" id="permissions_tab">
            <h2>Static Variables</h2>


            <table class="table input_fields_wrap" id="empTable" >
                <thead>
                <tr>
                    {{--<th>#</th>--}}
                    <th>Key</th>
                    <th>Value (AR)</th>
                    <th>Value (EN)</th>
                </tr>
                </thead>
                <tbody  id="myTable">
                @foreach($variables as $key => $val)
                <tr>
{{--                    <td>{{$key}}</td>--}}
                    <td><input type="text"
                               name="keys[]"
                               value="{{$val['key']}}"
                               class="form-control  input-data"></td>
                    <td><input type="text"
                               name="value_en[]"
                               value="{{$val['en']}}"
                               class="form-control  input-data"></td>
                    <td><input type="text"
                               name="value_ar[]"
                               value="{{$val['ar']}}"
                               dir="rtl"
                               class="form-control  input-data"></td>
                    <td>
                        <input  type="button" onclick="myDeleteFunction({{$key}}); return false;" value="Remove" />
                    </td>

                </tr>
                    @endforeach

                </tbody>
            </table>

            <button class="btn dark btn-outline add_field_button" onclick="addRow();return false;">Add New Row</button><br/><br/>

        </div>

        <div class="form-actions">
            <div class="row">
                <div class="col-md-offset-3 col-md-9">
                    <button type="submit" class="btn green">Submit</button>
                    <input type="reset" class="btn default" value="Reset">
                </div>
            </div>
        </div>
    </form>


@endsection

@section('scripts')
        <script>
        function myFunction() {
            var table = document.getElementById("myTable");
            var row = table.insertRow(0);
            var cell1 = row.insertCell(0);
            var cell2 = row.insertCell(1);
            var cell3 = row.insertCell(2);
            var cell4 = row.insertCell(3);
            cell1.innerHTML = '<input type="text" name="keys[]" value="" class="form-control  input-data">';
            cell2.innerHTML = '<input type="text" name="value_en[]" value="" class="form-control  input-data">';
            cell3.innerHTML = '<input type="text" name="value_ar[]" value="" class="form-control  input-data">';
            cell4.innerHTML = '<a  onclick="myDeleteFunction(0); return false;">Delete row</a>';
            return false;
        }
        function myDeleteFunction(cell) {
            document.getElementById("myTable").deleteRow(cell);
        }




        var arrHead = new Array();
        arrHead = ['', 'Employee Name', 'Designation', 'Age'];

        function addRow() {
            var empTab = document.getElementById('empTable');

            var rowCnt = empTab.rows.length;
            var tr = empTab.insertRow(rowCnt);
            tr = empTab.insertRow(rowCnt);

            for (var c = 0; c < arrHead.length; c++) {
                var td = document.createElement('td');
                td = tr.insertCell(c);

                if (c == 3) {
                    var button = document.createElement('input');
                    button.setAttribute('type', 'button');
                    button.setAttribute('value', 'Remove');
                    button.setAttribute('onclick', 'removeRow(this)');
                    td.appendChild(button);
                }
                else {
                    var ele = document.createElement('input');
                    ele.setAttribute('type', 'text');
                    ele.setAttribute('class', 'form-control  input-data');
                    ele.setAttribute('value', '');
                    td.appendChild(ele);
                }
            }
        }
        function removeRow(oButton) {
            var empTab = document.getElementById('empTable');
            empTab.deleteRow(oButton.parentNode.parentNode.rowIndex);
        }

        </script>

@endsection