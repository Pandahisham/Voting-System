@extends('layout.menu')

@section('body')
	<div class="pageheader">
		<h2>
			<i class="fa fa-user"></i> System User
		</h2>
	</div>

	<div class="main">
		<div class="row">

			<div class="col-md-12">

				<section class="tile transparent">

					<div class="tile-header transparent">
						<h1><strong>User</strong> Table</h1>
					</div>
			
					<div class="tile-body color transparent-black rounded-corners">
						
						<?php

							if(Session::has('msg-success')) {
								echo '<div class="notification notification-success">' .
								'<h4>' . Session::get('msg-success') . '</h4>' .
								'</div>';
							}

              if(Session::has('msg-error')) {
                echo '<div class="alert alert-red">' .
                      Session::get('msg-error') .
                      '</div>';
              }

						?>
						{{ Input::get('fname') }}
						<div class="table-responsive">
							<table class="table table-datatable table-custom" id="inlineEditDataTable">
								<thead>
									<tr>
										<th class="sort-numeric">Id</th>
										<th class="sort-alpha">First Name</th>
										<th class="sort-alpha">Middle Name</th>
										<th class="sort-alpha">Last Name</th>
										<th class="sort-alpha">User Type</th>
										<th class="sort-alpha">Username</th>
										<th class="no-sort">Profile Image</th>
										@if(Auth::user()->usertypeid == 1)
											<th class="no-sort">Actions</th>
										@endif
									</tr>
								</thead>
								<tbody>

									@foreach($users as $user)
										<tr>
											<td class="text-center">{{ $user->id }}</td>
											<td class="text-center">{{ ucwords($user->fname) }}</td>
											<td class="text-center">{{ ucwords($user->mname) }}</td>
											<td class="text-center">{{ ucwords($user->lname) }}</td>
											<td class="text-center">{{ ucwords($user->usertype) }}</td>
											<td class="text-center">{{ $user->username }}</td>
											<td class="text-center"><img src="{{ $user->image }}" style="width: 30px; height: 30px;"></td>
											@if(Auth::user()->usertypeid == 1)
												<td class="actions text-center"><a class="edit" href="/user/{{ $user->id }}/edit">Edit</a><a class="delete" href="#delete" id="{{ $user->id }}" data-toggle="modal">Delete</a></td>
											@endif
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>

					</div>

				</section>

			</div>

		</div>
	</div>

  <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="modalConfirmLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">Close</button>
          <h3 class="modal-title" id="modalConfirmLabel"><strong>Delete</strong> user</h3>
        </div>
        {{ Form::open(array('url' => '', 'method' => 'delete', 'id' => 'delete')) }}
        <div class="modal-body">
              
            {{ Form::hidden('delete-id') }}
            <p>Are you sure you want to delete user?</p>

        </div>
        <div class="modal-footer">
          <button class="btn btn-slategray" data-dismiss="modal" aria-hidden="true">Close</button>
          <input type="submit" class="btn btn-redbrown" value="Delete">
        </div>
        {{ Form::close() }}
      </div>
    </div>
  </div>
@stop

@section('script')
	<script>

		$(document) 
    		.on('change', '.btn-file :file', function() {
    			var input = $(this),
    			numFiles = input.get(0).files ? input.get(0).files.length : 1,
    			label = input.val().replace(/\\/g, 'http://tattek.com/').replace(/.*\//, '');
    			input.trigger('fileselect', [numFiles, label]);
    	 });

		$(function() {
			// file upload
			$('.btn-file :file').on('fileselect', function(event, numFiles, label) {
    			var input = $(this).parents('.input-group').find(':text'),
    			log = numFiles > 1 ? numFiles + ' files selected' : label;

    			if(input.length) {
    				input.val(log);
    			}
    			else {
    				if(log) alert(log);
    			}
    		});

			$(".chosen-select").chosen({disable_search_threshold: 10});

			// Add custom class to pagination div
      		$.fn.dataTableExt.oStdClasses.sPaging = 'dataTables_paginate paging_bootstrap paging_custom';

      		function restoreRow(oTable02, nRow) {
      			var aData = oTable02.fnGetData(nRow);
      			var jqTds = $('>td', nRow);

      			for(var i=0, iLen=jqTds.length ; i<iLen ; i++) {
      				oTable02.fnUpdate(aData[i], nRow, i, false);
      			}

      			oTable02.fnDraw();
      		};

      		function editRow(oTable02, nRow) {
      			var aData = oTable02.fnGetData(nRow);
      			var jqTds = $('>td', nRow);
      			jqTds[0].innerHTML = '<input type="text" value="'+aData[0]+'">';
      			jqTds[1].innerHTML = '<input type="text" value="'+aData[1]+'">';
      			jqTds[2].innerHTML = '<input type="text" value="'+aData[2]+'">';
      			jqTds[3].innerHTML = '<input type="text" value="'+aData[3]+'">';
      			jqTds[4].innerHTML = '<a class="edit save" href="#">Save</a><a class="delete" href="#">Delete</a>';
      		};

      		function saveRow(oTable02, nRow) {
      			var jqInputs = $('input', nRow);
      			oTable02.fnUpdate( jqInputs[0].value, nRow, 0, false );
		        oTable02.fnUpdate( jqInputs[1].value, nRow, 1, false );
		        oTable02.fnUpdate( jqInputs[2].value, nRow, 2, false );
		        oTable02.fnUpdate( jqInputs[3].value, nRow, 3, false );
		        oTable02.fnUpdate( '<a class="edit" href="#">Edit</a><a class="delete" href="#">Delete</a>', nRow, 4, false );
		        oTable02.fnDraw();
      		};

      		var oTable02 = $('#inlineEditDataTable').dataTable({
      			"sDom":
      				"R<'row'<'col-md-6'l><'col-md-6'f>r>"+
      				"t"+
      				"<'row'<'col-md-4 sm-center'i><'col-md-4'><'col-md-4 text-right sm-center'p>>",
      			"oLanguage": {
      				"sSearch": ""
      			},
      			"aaSorting": [[ 0, "desc" ]],
      			"aoColumnDefs": [
      				{ 	'bSortable': false, 
      					'aTargets': [ "no-sort" ] ,
      				}
      			],
      			"fnInitComplete": function(oSettings, json) {
      				$('.dataTables_filter input').attr("placeholder", "Search");
      			}
      		});

      		// hide first column
      		oTable02.fnSetColumnVis(0, false);

      		// append add row button to table
      		var addRowLink = '<a href="user/create" id="addRow" class="btn btn-green btn-xs add-row">Add User</a>'
      		$('#inlineEditDataTable_wrapper').append(addRowLink);

      		var nEditing = null;

      		// // add row initialize
      		// $('#addRow').click(function(e) {
      		// 	e.preventDefault();

      		// 	// only allow a new row when not currently editing
      		// 	if(nEditing !== null) {
      		// 		return;
      		// 	}

      		// 	var aiNew = oTable02.fnAddData([ '', '', '', '', '', '<a class="edit" href="#">Edit</a>', '<a class="delete" href="#">Delete</a>' ]);
      		// 	var nRow = oTable02.fnGetNodes(aiNew[0]);
      		// 	editRow(oTable02, nRow);
      		// 	nEditing = nRow;

      		// 	$(nRow).find('td:last-child').addClass('actions text-center');
      		// });

      		// delete row initialize
      		// $(document).on("click", "#inlineEditDataTable a.delete", function(e) {
      		// 	e.preventDefault();

      		// 	var nRow = $(this).parents('tr')[0];
      		// 	oTable02.fnDeleteRow(nRow);
      		// 	nEditing = null;
      		// });

      		// // edit row initialize
      		// $(document).on("click", "#inlineEditDataTable a.edit", function(e) {
      		// 	e.preventDefault();

      		// 	// get the row as a parent of the link that was clicked on
      		// 	var nRow = $(this).parents('tr')[0];

      		// 	if(nEditing !== null && nEditing != nRow) {
      		// 		// a different row is being edited - the edit should be cancelled and this row edited
      		// 		//restoreRow(oTable02, nEditing);

      		// 		// only allow a new row when not currently editing
	      	// 		if(nEditing !== null) {
	      	// 			return;
	      	// 		}

      		// 		editRow(oTable02, nRow);
      		// 		nEditing = nRow;
      		// 	}
      		// 	else if (nEditing == nRow && this.innerHTML == "Save") {
      		// 		// this row is being edited and should be saved
      		// 		saveRow(oTable02, nEditing);
      		// 		nEditing = null;
      		// 	}
      		// 	else {
      		// 		// no row currently being edited
      		// 		editRow(oTable02, nRow);
      		// 		nEditing = nRow;
      		// 	}
      		// });
          
          // delete function
          $(document).on("click", "#inlineEditDataTable a.delete", function(e) {
            var id = $(this).attr('id');
            
            $('input[name="delete-id"]').val(id);
            $('form#delete').attr('action', 'user/' + id);
          });
      	})
	</script>
@stop