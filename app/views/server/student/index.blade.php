@extends('layout.menu')

@section('body')
	<div class="pageheader">
		<h2>
			<i class="fa fa-user"></i> Student
		</h2>
	</div>

	<div class="main">
		<div class="row">
			
			<div class="col-md-12">

				<section class="tile transparent">

					<div class="tile-header transparent">
						<h1><strong>Student</strong> Table</h1>
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
						
						<div class="table-responsive">
							<table class="table table-datatable table-custom" id="inlineEditDataTable">
								<thead>
									<tr>
										<th class="sort-numeric">Id</th>
										<th class="sort-alpha">Name</th>
										<th class="sort-numeric">Course</th>
										<th class="sort-numeric">Voted</th>
										@if(Auth::user()->usertype_id == 1)
											<th class="no-sort">Actions</th>
										@endif
									</tr>
								</thead>
								<tbody>

									@foreach($students as $student)
										<tr>
											<td class="text-center">{{ $student->id }}</td>
											<td class="text-center">{{ ucwords($student->fname) . ' ' . ucwords($student->mname) . ' ' . ucwords($student->lname) }}</td>
											<td class="text-center">{{ $student->course->name . ' - ' . $student->course->description }}</td>
											<td class="text-center"><?php echo $student->isVoted == '1' ? '<i class="fa fa-check" style="color: rgb(6, 226, 6);"></i>' : '<span style="color: rgb(178, 26, 26); font-weight: bolder;">X</span>'; ?></td>
											@if(Auth::user()->usertype_id == 1)
												<td class="actions text-right"><a class="edit" href="/student/{{ $student->id }}/edit">Edit</a><a class="delete" href="#delete" id="{{ $student->id }}" data-toggle="modal">Delete</a></td>
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
	            <h3 class="modal-title" id="modalConfirmLabel"><strong>Delete</strong> student</h3>
	        </div>
	        {{ Form::open(array('url' => '', 'method' => 'delete', 'id' => 'delete')) }}
	        <div class="modal-body">
	              
	            {{ Form::hidden('delete-id') }}
	            <p>Are you sure you want to delete student?</p>

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
		$(function() {
			// Add custom class to pagination div
      		$.fn.dataTableExt.oStdClasses.sPaging = 'dataTables_paginate paging_bootstrap paging_custom';

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
      		var addRowLink = '<a href="student/create" id="addRow" class="btn btn-green btn-xs add-row">Add Student</a><a type="button" href="/print/notvoted" class="btn btn-default"><i class="fa fa-print" style="font-size: 20px;"></i> <span style="font-size: 12px;">Student\'s not voted</span></a>'
      		$('#inlineEditDataTable_wrapper').append(addRowLink);

      		var nEditing = null;
          
	        // delete function
	        $(document).on("click", "#inlineEditDataTable a.delete", function(e) {
	            var id = $(this).attr('id');
	            
	            $('input[name="delete-id"]').val(id);
	            $('form#delete').attr('action', 'student/' + id);
	        });

	         //initialize chosen
      		$('.dataTables_length select').chosen({disable_search_threshold: 10});
		})
	</script>
@stop