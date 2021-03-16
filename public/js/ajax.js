let current_session_id = $("input#current_session_id").val();

function open_global_archive_modal(id, name)
{
	$("#global_archive_modal #archive_project_name").html(name);
    $("#global_archive_modal #archive_project_id").val(id);
	$("#global_archive_modal").modal('show');
}
$.ajax({
	type: 'GET',
	url: '/fetch/'+current_session_id+'/recently/viewed/projects',
	success: function(res){
		$("#recently_viewed_projects_div").html(res);
	}
});
$.ajax({
	type: 'GET',
	url: '/fetch/'+current_session_id+'/uploads',
	success: function(res){
		if(res.length > 0)
		{
			let tr = '';
			$("#headerUploadsButton").show();
			$("#headerUploadsButton .badge").html(res.length);
			$("#UploadedCount").html(res.length);

			res.forEach((item) => {
				if(item.type == 'plan'){
					tr = '<tr><td><div class="upload-filename"><i class="fa fa-file"></i> '+item.name+'</div></td><td class="upload-status">Finished</td><td class="upload-action"><a class="btn btn-primary btn-xs" href="/project/'+item.project_salt+'/plans/'+item.plan_salt+'/editor">Open Plan</a></td></tr>';
				}else{
					tr = '<tr><td><div class="upload-filename"><i class="fa fa-file"></i> '+item.name+'</div></td><td class="upload-status">Finished</td><td class="upload-action"><a class="btn btn-primary btn-xs" href="/projects/'+item.project_salt+'/attachments">Attachments List</a></td></tr>';
				}
				$("table.queue-list tbody").append(tr);
			});
		}
	}
});
$.ajax({
	type: 'GET',
	url: '/fetch/session/active-plan',
	success: function(res){
		console.log(res);
		if(res.length != '')
		{
			$("#bottom_header .tab5").css('display','inline-block');
			$("#bottom_header .tab5 a").attr('href','/project/'+res.project_salt+'/plans/'+res.plan_salt+'/editor');
			$("#bottom_header .tab5 span").text(res.name);
		}
	}
});
$("#headerUploadsButton").click(function(){
	$("#uploader-container").toggle();
});
$("#uploader-container #close").click(function(){
	$("#uploader-container").toggle();
});
