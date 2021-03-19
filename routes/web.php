<?php

use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\usersController;
use App\Http\Controllers\Admin\adminController;
use App\Http\Controllers\Projects\projectsController;
use App\Http\Controllers\Projects\statusesController;
use App\Http\Controllers\Projects\symbolsController;
use App\Http\Controllers\Projects\labelsController;
use App\Http\Controllers\Projects\takeofflabelsController;
use App\Http\Controllers\Projects\templatesController;
use App\Http\Controllers\Projects\takeoffTemplatesController;
use App\Http\Controllers\Projects\ProjectPlansController;
use App\Http\Controllers\Projects\InvitationsController;
use App\Http\Controllers\Projects\sharingsController;
use App\Http\Controllers\billingsController;
use App\Http\Controllers\attachmentsController;
use App\Http\Controllers\stagesController;
use App\Http\Controllers\calendarsController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\measurementsController;
use App\Http\Controllers\editorsController;
use App\Http\Controllers\additionalItemsController;
use App\Http\Controllers\Projects\Template_todosController;
use App\Http\Controllers\Projects\Activity_LogController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('/signup');
});
Route::get('/login',[usersController::class, 'view_signin_page']);
Route::get('/signup',[usersController::class, 'view_signup_page']);
Route::post('/login',[usersController::class, 'signin'])->name('user.login');
Route::post('/signup',[usersController::class, 'signup'])->name('user.register');
Route::post('/logout',[usersController::class, 'logout'])->name('user.logout');
Route::get('/account/activate', [usersController::class, 'activate_account']);
Route::post('/resend/confirmation/email',[usersController::class, 'resend_confirmation_email'])->name('resend.accountconfirmationemail');
Route::get('/forgot-password',[usersController::class, 'view_forgot_password_page']);
Route::post('/recover-password',[usersController::class, 'recover_password'])->name('user.recover');
Route::get('/recover/password', [usersController::class, 'show_change_pass_page']);
Route::post('/user/rest/password',[usersController::class, 'update_user_password'])->name('user.reset.password');

Route::post('/change-name',[usersController::class, 'change_name'])->name('user.changename');
Route::post('/change-timezone',[usersController::class, 'change_timezone'])->name('user.changetimezone');
Route::post('/change-password',[usersController::class, 'change_password'])->name('user.changepassword');

// Google Login
Route::get('/signup/google',[GoogleController::class, 'redirectToGoogle']);
Route::get('/signup/google/callback',[GoogleController::class, 'handleGoogleCallback']);


Route::get('/setup/profile',[projectsController::class, 'profileSetupPage']);
Route::get('/setup/symbols',[symbolsController::class, 'mySymbolsPage']);
Route::post('/setup/symbols/add-category',[symbolsController::class, 'addCategory'])->name('symbol.category.add');
Route::post('/setup/symbols/add',[symbolsController::class, 'addSymbol'])->name('symbol.add');
Route::post('/symbols/category/edit',[symbolsController::class, 'editCategoryName'])->name('category.edit');
Route::post('/symbols/category/delete',[symbolsController::class, 'deleteCategory'])->name('category.delete');
Route::post('/symbols/pack/install',[symbolsController::class, 'install_pack'])->name('pack.install');


Route::get('/fetch/{id}/recently/viewed/projects', [projectsController::class, 'fetch_recent_viewed_projects']);

Route::get('/setup/project-status',[statusesController::class, 'prjectStatusPage']);
Route::get('/setup/project-status-get',[statusesController::class, 'getAllStatuses'])->name('status.getStatuses');
Route::POST('/setup/project-status-add',[statusesController::class, 'prjectStatusadd'])->name('status.add');
Route::get('/setup/project-status-delete-status-{id}',[statusesController::class, 'delete_status'])->name('status.remove');
Route::post('/setup/project-status-edit',[statusesController::class, 'update_status'])->name('status.update');
Route::post('/setup/status-sort-up',[statusesController::class, 'statusSortUp'])->name('status.sortup');
Route::post('/setup/status-sort-down',[statusesController::class, 'statusSortDown'])->name('status.sortdown');

Route::PUT('/setup/project-reason-add',[statusesController::class, 'prjectReasonadd'])->name('reason.add');
Route::get('/setup/project-status-delete-reason-{id}',[statusesController::class, 'delete_reason'])->name('reason.remove');
Route::post('/setup/project-reason-edit',[statusesController::class, 'update_reason'])->name('reason.update');
Route::post('/setup/project-reason-sort',[statusesController::class, 'reasonsSort'])->name('reasons.sort');

Route::get('/setup/project-label',[labelsController::class, 'prjectLabelPage']);
Route::POST('/setup/project-labels-add',[labelsController::class, 'projectLabeladd'])->name('labels.add');
Route::get('/setup/project-label-delete-label-{id}',[labelsController::class, 'delete_label'])->name('label.remove');
Route::post('/setup/project-label-edit',[labelsController::class, 'update_label'])->name('label.update');
Route::post('/setup/project-label-sort',[labelsController::class, 'labelsSort'])->name('labels.sort');

Route::get('/setup/takeoff-label',[takeofflabelsController::class, 'takeLabelPage']);
Route::POST('/setup/project-takeofflabel-add',[takeofflabelsController::class, 'prjectLabeladd'])->name('label.add');
Route::get('/setup/takeofflabel/delete/{id}',[takeofflabelsController::class, 'delete_label']);
Route::post('/setup/project-takeofflabel-edit',[takeofflabelsController::class, 'update_label'])->name('takeofflabel.update');
Route::post('/setup/project-takeofflabel-sort',[takeofflabelsController::class, 'labelsSort'])->name('takeofflabels.sort');
Route::get('/setup/user/activity', [Activity_LogController::class, 'user_activity_index']);

// ========== Licences/ Invitaions Routes=========
Route::get('/setup/users',[usersController::class, 'show_licences_page']);
Route::post('/setup/users/licences/update',[usersController::class, 'update_licences']);
Route::post('/setup/invite/user',[invitationsController::class, 'invite_user'])->name('invite.user');
Route::get('/user/join',[invitationsController::class, 'accept_invite']);
Route::post('setup/user/deactivate',[invitationsController::class, 'deactivate_user'])->name('user.deactivate');
Route::post('setup/user/activate',[invitationsController::class, 'activate_user'])->name('user.activate');
// ========== Billing Routes=========
Route::get('/test/plans',[SubscriptionController::class, 'retrievePlans']);
Route::get('/setup/billing',[billingsController::class, 'show_biling_page'])->middleware('session')->name('billing.setup');
Route::post('/setup/billing/update',[billingsController::class, 'update'])->name('billing.update');
Route::post('/setup/billing/add/creit_info',[billingsController::class, 'add_credit_card'])->name('creditcard.add');
Route::post('/setup/billing/remove/creit_info',[billingsController::class, 'remove_credit_card'])->name('creditcard.remove');

// ==========Projects Routes=========

Route::get('/projects/open', [projectsController::class, 'index']);
Route::get('/projects/open/detail_list', [projectsController::class, 'change_to_detail_list']);
Route::get('/projects/open/compact_list', [projectsController::class, 'change_to_compact_list']);
Route::get('/projects/open/table', [projectsController::class, 'change_to_table_view']);
Route::get('/projects/open/sortby:Z-A', [projectsController::class, 'index_Z_A']);
Route::get('/projects/open/sortby:A-Z', [projectsController::class, 'index_A_Z']);
Route::get('/projects/open/Oldest-First', [projectsController::class, 'index_Older']);
Route::get('/projects/open/filterby:{id}', [projectsController::class, 'filter_by']);
Route::post('/projects/open/search', [projectsController::class, 'search'])->name('projects.search');
Route::get('/projects/open/search', [projectsController::class, 'search_view']);
Route::get('/projects/create', [projectsController::class, 'create_index']);
Route::post('/projects/create', [projectsController::class, 'create_project'])->name('project.create');
Route::get('/project/{id}/overview/details', [projectsController::class, 'overview']);
Route::get('/projects/{id}/overview/details/edit', [projectsController::class, 'edit_view']);
Route::post('/project/update', [projectsController::class, 'update'])->name('project.update');
Route::get('/projects/{id}/delete', [projectsController::class, 'delete_project']);
Route::get('/projects/{id}/archive', [projectsController::class, 'archive_project']);
Route::get('/projects/trash', [projectsController::class, 'view_trash_page']);
Route::get('/projects/{id}/deleted/restore', [projectsController::class, 'restore_deleted_project']);
Route::post('/projects/change-status', [projectsController::class, 'changestatus'])->name('project.changestatus');
Route::post('/projects/duplicate-project', [projectsController::class, 'duplicateproject'])->name('project.duplicateproject');

Route::get('/projects/archive', [projectsController::class, 'view_archive_page']);
Route::post('/projects/add-to-archive', [projectsController::class, 'add_to_archive'])->name('project.addtoarchive');
Route::post('/projects/unarchive', [projectsController::class, 'unarchive_project'])->name('project.unarchive');

// ====TODO====
Route::get('/projects/{salt}/open/todo', [projectsController::class, 'todo_view'])->middleware('session');
Route::POST('/projects/open/todo', [projectsController::class, 'store_todo'])->name('project_todo.add');
Route::get('/projects/open/todo/delete/{id}/{project_id}', [projectsController::class, 'delete_todo']);
Route::get('/projects/open/todo/mark-completed/{id}/{project_id}', [projectsController::class, 'mark_complete_todo']);
Route::get('/projects/open/todo/mark-uncompleted/{id}/{project_id}', [projectsController::class, 'mark_uncomplete_todo']);
Route::POST('/projects/open/todo/update', [projectsController::class, 'update_todo'])->name('todo.update');
Route::POST('/projects/todo/update_start_date', [projectsController::class, 'update_todo_start_date'])->name('todo.update_start_date');
Route::POST('/projects/todo/update_end_date', [projectsController::class, 'update_todo_end_date'])->name('todo.update_end_date');

//===== ATTACHMENTS START =====
Route::GET('/projects/{salt}/attachments', [attachmentsController::class, 'index'])->middleware('session');
Route::POST('/projects/attachment/upload', [attachmentsController::class, 'upload']);
Route::POST('/projects/attachment/fetch', [attachmentsController::class, 'fetching_attachments']);
Route::GET('/attachment/{id}/{project}/delete', [attachmentsController::class, 'delete'])->middleware('session');

//===== CALENDAR START =====
Route::GET('/projects/calendar',[calendarsController::class, 'index'])->middleware('session');
//===== STAGE START =====
Route::GET('/projects/{salt}/stages',[stagesController::class, 'index'])->middleware('session');
Route::POST('/projects/stages/add',[stagesController::class, 'create'])->name('stage.add');
Route::POST('/projects/stages/delete',[stagesController::class, 'delete'])->name('stage.delete');
Route::POST('/projects/stages/update',[stagesController::class, 'update'])->name('stage.update');
Route::POST('/projects/stages/add-with-plan',[stagesController::class, 'create_plan_stage'])->name('stage.add2');
Route::POST('/editor/stage/add-count',[measurementsController::class, 'add_count_editor'])->name('editor.addcount');
Route::POST('/editor/measurement/delete',[editorsController::class, 'delete_measurements'])->name('editor.measurement.delete');
Route::POST('/worksheet/stage/update/info',[measurementsController::class, 'update_stage_info'])->name('worksheet.stage.update');
Route::POST('/worksheet/stage/update/measurements',[measurementsController::class, 'update_stage_measurements'])->name('worksheet.stage.editmeasurements');
Route::POST('/worksheet/stage/apply-to-template',[measurementsController::class, 'apply_to_template'])->name('worksheet.stage.applytemplate');
Route::POST('/worksheet/stage/delete',[stagesController::class, 'delete_stage_worksheet'])->name('worksheet.stage.delete');

// ===== Sharing =====
Route::GET('/projects/{salt}/sharing',[sharingsController::class, 'index'])->middleware('session');
Route::POST('/projects/sharing/search',[sharingsController::class, 'search'])->name('sharing.search');
Route::POST('/projects/sharing/invite',[sharingsController::class, 'invite'])->name('sharing.invite');
Route::get('/projects/{project_id}/invite/{user_id}/{invited_by}/accept',[sharingsController::class, 'accept_invite']);

//=========Export======
Route::get('/projects/{salt}/export',[projectsController::class, 'export_view']);

// // =======PLANS=========
Route::get('/project/{salt}/plans', [ProjectPlansController::class, 'plans_view']);
Route::POST('/projects/plans/upload', [ProjectPlansController::class, 'upload_plan'])->name('upload.plan');
Route::POST('/projects/plans/fetch', [ProjectPlansController::class, 'fetch'])->name('fetch.plans');
Route::get('/project/{project_salt}/plans/{plan_salt}/editor', [ProjectPlansController::class, 'plans_edit_view']);
Route::POST('/projects/plans/delete', [ProjectPlansController::class, 'delete_plan'])->name('delete.plan');
Route::POST('/projects/plans/group/create', [ProjectPlansController::class, 'create_group'])->name('group.add');
Route::POST('/projects/plans/group/rename', [ProjectPlansController::class, 'rename_group'])->name('group.rename');
Route::POST('/projects/plans/group/delete/plans', [ProjectPlansController::class, 'delete_group_plans'])->name('group.deleteplans');
Route::POST('/projects/plans/group/delete/group', [ProjectPlansController::class, 'delete_group'])->name('group.deletegroup');
Route::get('/fetch/session/active-plan',[ProjectPlansController::class, 'fetch_active_plan']);
// ============ UPLOADS ROUTES ================
Route::get('/fetch/{id}/uploads', [ProjectPlansController::class, 'fetch_uploads']);
Route::post('/uploads/user/delete', [ProjectPlansController::class, 'remove_uploads'])->name('uploads.delete');

// =======PLANS END=========

// ======= Worksheet Routes =========
Route::get('/project/{salt}/worksheet', [measurementsController::class, 'worksheet_page']);
Route::POST('/project/worksheet/count/add', [measurementsController::class, 'add_count'])->name('add.count');
Route::POST('/project/worksheet/count/adjust', [measurementsController::class, 'adjust_count'])->name('adjust.count');
Route::POST('/project/worksheet/rename/measurement', [measurementsController::class, 'rename'])->name('rename.measurement');
Route::POST('/project/worksheet/delete/measurement', [measurementsController::class, 'delete'])->name('delete.measurement');
Route::POST('/project/worksheet/additonal/add', [additionalItemsController::class, 'create'])->name('additional.add');
Route::POST('/project/worksheet/additonal/delete', [additionalItemsController::class, 'delete'])->name('additional.delete');
Route::POST('/project/worksheet/additonal/update', [additionalItemsController::class, 'update'])->name('additional.update');
Route::get('/project/{project_salt}/measurements/{measurement_id}/edit/worksheet',[measurementsController::class, 'worksheet_measurement_edit_page']);
// Quantities Routes
Route::get('/project/{salt}/quantities', [measurementsController::class, 'quantities_page']);


//Project Template Routes
Route::get('/project-templates/open',[templatesController::class, 'index']);
Route::post('/project/template/create', [templatesController::class, 'create'])->name('template.add');
Route::post('/project/template/update', [templatesController::class, 'update'])->name('template.update');
Route::post('/project/template/duplicate', [templatesController::class, 'duplicate'])->name('template.duplicate');
// Route::post('/project/template/delete', [templatesController::class, 'delete'])->name('template.delete');
Route::get('/project-templates/open/{id}/delete',[templatesController::class, 'delete']);
Route::get('/project-templates/trash',[templatesController::class, 'trash_index']);
Route::get('/project-templates/open/{id}/undo',[templatesController::class, 'restore']);
Route::post('/template/sharing/search', [templatesController::class, 'search_email'])->name('template.searchuser');
Route::post('/template/sharing/invite', [templatesController::class, 'invite_user'])->name('template.inviteuser');
Route::get('/templates/{template_salt}/invite/{user_id}/{invited_by}/accept',[templatesController::class, 'accept_invite']);

// ========Takeoff Templates=========
Route::get('/takeoff-templates/open',[takeoffTemplatesController::class, 'index']);
Route::post('/takeoff/template/create', [takeoffTemplatesController::class, 'create'])->name('takeoff-template.add');
Route::post('/takeoff/template/update', [takeoffTemplatesController::class, 'update'])->name('takeoff-template.update');
Route::post('/takeoff/template/duplicate', [takeoffTemplatesController::class, 'duplicate'])->name('takeoff-template.duplicate');
Route::get('/takeoff-templates/{id}/edit', [templatesController::class, 'edit_page']);
Route::get('/takeoff-templates/open/{id}/delete',[takeoffTemplatesController::class, 'delete']);
Route::get('/takeoff-templates/trash',[takeoffTemplatesController::class, 'trash_index']);
Route::get('/takeoff-templates/open/{id}/undo',[takeoffTemplatesController::class, 'restore']);
Route::post('/takeoff/template/add-label', [takeoffTemplatesController::class, 'edit_takeofflabel'])->name('takeoff_temlates.addlabels');
Route::get('/takeoff-templates/{salt}',[takeoffTemplatesController::class, 'details_page']);
Route::post('/takeoff/template/fetch/labels', [takeoffTemplatesController::class, 'fetch_labels'])->name('takeoff_temlates.fetchlabels');
Route::post('/takeoff/template/labels/remove', [takeoffTemplatesController::class, 'remove_label'])->name('takeoff_temlates.labelremove');

Route::get('/takeoff-templates/{salt}/{id}/measurements/edit',[takeoffTemplatesController::class, 'measurements_edit']);
Route::POST('/measurements/edit',[takeoffTemplatesController::class, 'measurements_name_update'])->name('measurements_name.update');
Route::POST('/measurements/style/edit',[takeoffTemplatesController::class, 'measurements_style_update'])->name('updatestyle.measurement');
Route::POST('/measurements/style/edit/length',[takeoffTemplatesController::class, 'measurements_length_style_update'])->name('updatelengthstyle.measurement');
Route::POST('/measurements/style/edit/area',[takeoffTemplatesController::class, 'measurements_area_style_update'])->name('updatearastyle.measurement');
Route::POST('/project/delete/measurement/part', [takeoffTemplatesController::class, 'delete_part'])->name('delete.part');
Route::POST('/project/measurement/part/update', [takeoffTemplatesController::class, 'measurement_part_update'])->name('measurement.editparts');
Route::POST('/project/measurement/part/add', [takeoffTemplatesController::class, 'measurement_part_add'])->name('measurements.addpart');
Route::POST('/project/measurement/part/edit', [takeoffTemplatesController::class, 'measurement_labours_edit'])->name('measurements.editlabour');

// EDITOR ROUTES
Route::POST('editor/fetch/stages',[stagesController::class, 'fetch_stages'])->name('stages.fetch');
Route::POST('/editor/plan/stage/delete',[stagesController::class, 'delete_plan_stage'])->name('planstages.delete');

//Project Overview

Route::get('/project/{id}/overview/activity', [Activity_LogController::class, 'activity_index']);


//Project Template Routes
Route::get('/project/template/{salt}/tasks', [templatesController::class, 'template_todo']);
Route::get('/project/template/{salt}/stages', [templatesController::class, 'template_stages']);
Route::get('/project/template/{salt}/sharing', [templatesController::class, 'template_sharing']);
Route::POST('/projects/template/open/todo', [Template_todosController::class, 'store_todo'])->name('template_todo.add');
// Route::get('/projects/template/todo/delete/{id}', [Template_todosController::class, 'delete_todo']);
Route::POST('/projects/template/todo/update', [Template_todosController::class, 'update_todo'])->name('todo_template.update');
Route::get('/project/template/clear/tasks', [templatesController::class, 'template_todo']);
Route::POST('/projects/template/todo/task/add', [Template_todosController::class, 'add_todo_task'])->name('todo_template_task.add');
Route::POST('/projects/template/todo/task/update', [Template_todosController::class, 'rename_todo_task'])->name('todo_template_task.update');
Route::POST('/projects/template/todo/task/delete', [Template_todosController::class, 'delete_todo_task'])->name('todo_template_task.delete');
Route::POST('/projects/template/todo/clear/tasks', [Template_todosController::class, 'clear_todo_tasks'])->name('todo_template_tasks.clear');
Route::POST('/projects/template/todo/delete', [Template_todosController::class, 'delete_todo'])->name('todo_template.delete');

// ======= Worksheet
Route::get('/dashboard/active-projects/{id}/worksheet',[adminController::class, 'activeProject_worksheet'])->name('activeProject.worksheet');











//=============== Admin ====================
Route::get('/admin-login',[adminController::class, 'admin_login']);
Route::post('/admin-login',[adminController::class, 'admin_logined'])->name('admin.logined');
Route::get('admin-logout', [adminController::class, 'admin_logout'])->name('admin.logout');
Route::get('/dashboard/all-users',[adminController::class, 'all_users']);
Route::get('/dashboard/all-users/{id}/billings',[adminController::class, 'userBilling_details'])->name('user.billing');
Route::get('/dashboard/all-users/{id}/project-statuses',[adminController::class, 'userproject_statues_details'])->name('user.project_statuses');
Route::get('/dashboard/all-users/{id}/delete-stage',[adminController::class, 'userProjectStatus_delete'])->name('userProjectStatus.del');

Route::get('/dashboard/all-users/{id}/project-labels',[adminController::class, 'userproject_labels_details'])->name('user.project_labels');
Route::get('/dashboard/all-users/{id}/delete-label',[adminController::class, 'userProjectLabel_delete'])->name('userProjectLabel.del');

Route::get('/dashboard/all-users/{id}/take-off-label',[adminController::class, 'usertake_off_labels_details'])->name('user.take_off_label');
Route::get('/dashboard/all-users/{id}/delete-takeoff',[adminController::class, 'userTakeoffLabel_delete'])->name('userTakeoffLabel.del');

Route::get('/dashboard/all-users/{id}/archieve-reason',[adminController::class, 'userarchieve_reason_details'])->name('user.archieve_reason');
Route::get('/dashboard/all-users/{id}/delete-reason',[adminController::class, 'userProjectReason_delete'])->name('userProjectReason.del');
Route::get('/dashboard/add-admin',[adminController::class, 'add_admin']);
Route::post('/dashboard/add-admin',[adminController::class, 'added_admin'])->name('admin.add');
Route::get('/dashboard/all-users/{id}',[adminController::class, 'user_delete'])->name('user.delete');
Route::get('/dashboard/edit-users/{id}',[adminController::class, 'user_update'])->name('update.user');
Route::post('/dashboard/edit-users/{id}',[adminController::class, 'user_updated'])->name('user.updated');
Route::get('/dashboard/change-password',[adminController::class, 'change_password']);
Route::post('/dashboard/change-password',[adminController::class, 'changed_password'])->name('changed.password');

Route::get('/dashboard/active-projects',[adminController::class, 'active_projects']);
Route::get('/dashboard/archived-projects',[adminController::class, 'archived_projects']);
Route::get('/dashboard/trashed-projects',[adminController::class, 'trashed_projects']);

Route::get('/dashboard/active-projects/{id}',[adminController::class, 'activeProjects_delete'])->name('activeProject.delete');
Route::get('/dashboard/archived-projects/{id}',[adminController::class, 'archivedProjects_delete'])->name('archivedProject.delete');
Route::get('/dashboard/trashed-projects/{id}',[adminController::class, 'trashedProjects_delete'])->name('trashedProject.delete');

Route::get('/dashboard/active-projects/{id}/details',[adminController::class, 'activeProject_details'])->name('activeProject.details');
Route::get('/dashboard/archived-projects/{id}/details',[adminController::class, 'archivedProject_details'])->name('archivedProject.details');
Route::get('/dashboard/trashed-projects/{id}/details',[adminController::class, 'trashedProject_details'])->name('trashedProject.details');

Route::get('/dashboard/active-projects/{id}/plans',[adminController::class, 'activeProject_plans'])->name('activeProject.plans');
Route::get('/dashboard/active-projects/{id}/delete-plans',[adminController::class, 'activeProjectPlan_delete'])->name('activeProjectPlan.del');

Route::get('/dashboard/archived-projects/{id}/plans',[adminController::class, 'archivedProject_plans'])->name('archivedProject.plans');
Route::get('/dashboard/archived-projects/{id}/delete-plan',[adminController::class, 'archivedProjectPlan_delete'])->name('archivedProjectPlan.del');

Route::get('/dashboard/trashed-projects/{id}/plans',[adminController::class, 'trashedProject_plans'])->name('trashedProject.plans');
Route::get('/dashboard/trashed-projects/{id}/delete-plan',[adminController::class, 'trashedProjectPlan_delete'])->name('trashedProjectPlan.del');

// ======= Worksheet Admin
Route::get('/dashboard/active-projects/{id}/worksheet',[adminController::class, 'activeProject_worksheet'])->name('activeProject.worksheet');

Route::get('/dashboard/archived-projects/{id}/worksheet',[adminController::class, 'archivedProject_worksheet'])->name('archivedProject.worksheet');

Route::get('/dashboard/trashed-projects/{id}/worksheet',[adminController::class, 'trashedProject_worksheet'])->name('trashedProject.worksheet');
// ----------------------------------------------------
//New admin
Route::get('/dashboard/active-projects/{id}/todos',[adminController::class, 'activeProject_todos'])->name('activeProject.todos');
Route::get('/dashboard/active-projects/{id}/delete-todo',[adminController::class, 'activeProjectTodo_delete'])->name('activeProjectTodo.del');

Route::get('/dashboard/archived-projects/{id}/todos',[adminController::class, 'archivedProject_todos'])->name('archivedProject.todos');
Route::get('/dashboard/archived-projects/{id}/delete-todo',[adminController::class, 'archivedProjectTodo_delete'])->name('archivedProjectTodo.del');

Route::get('/dashboard/trashed-projects/{id}/todos',[adminController::class, 'trashedProject_todos'])->name('trashedProject.todos');
Route::get('/dashboard/trashed-projects/{id}/delete-todo',[adminController::class, 'trashedProjectTodo_delete'])->name('trashedProjectTodo.del');

Route::get('/dashboard/active-projects/{id}/stages',[adminController::class, 'activeProject_stages'])->name('activeProject.stages');
Route::get('/dashboard/active-projects/{id}/delete-stage',[adminController::class, 'activeProjectStage_delete'])->name('activeProjectStage.del');

Route::get('/dashboard/archived-projects/{id}/stages',[adminController::class, 'archivedProject_stages'])->name('archivedProject.stages');
Route::get('/dashboard/archived-projects/{id}/delete-stage',[adminController::class, 'archivedProjectStage_delete'])->name('archivedProjectStage.del');

Route::get('/dashboard/trashed-projects/{id}/stages',[adminController::class, 'trashedProject_stages'])->name('trashedProject.stages');
Route::get('/dashboard/trashed-projects/{id}/delete-stage',[adminController::class, 'trashedProjectStage_delete'])->name('trashedProjectStage.del');

Route::get('/dashboard/active-projects/{id}/attachments',[adminController::class, 'activeProject_attachments'])->name('activeProject.attachments');
Route::get('/dashboard/active-projects/{id}/delete-attachment',[adminController::class, 'activeProjectAttachment_delete'])->name('activeProjectAttachment.del');

Route::get('/dashboard/archived-projects/{id}/attachments',[adminController::class, 'archivedProject_attachments'])->name('archivedProject.attachments');
Route::get('/dashboard/archived-projects/{id}/delete-attachment',[adminController::class, 'archivedProjectAttachment_delete'])->name('archivedProjectAttachment.del');

Route::get('/dashboard/trashed-projects/{id}/attachments',[adminController::class, 'trashedProject_attachments'])->name('trashedProject.attachments');
Route::get('/dashboard/trashed-projects/{id}/delete-attachment',[adminController::class, 'trashedProjectAttachment_delete'])->name('trashedProjectAttachment.del');

//============== Admin Templates
Route::get('/dashboard/all-users/{id}/project-template',[adminController::class, 'projectTemplate_user'])->name('projectTemplate.user');
Route::get('/dashboard/all-users/project-template/{id}/delete',[adminController::class, 'tempProject_delete'])->name('tempProject.del');
Route::get('/dashboard/all-users/project-template/{id}/stage',[adminController::class, 'tempProject_stage'])->name('tempProject.stage');
Route::get('/dashboard/all-users/project-template/stage/{id}/delete',[adminController::class, 'tempProjectStage_delete'])->name('tempProjectStage.del');
Route::get('/dashboard/all-users/project-template/{id}/todos' ,[adminController::class, 'tempProject_todos'])->name('tempProject.todos');
Route::get('/dashboard/template/active-projects/{id}/delete-todoTask',[adminController::class, 'tempProjectTodo_delete'])->name('tempProjectTodo.del');

// ============== Takeoff Template ===========
Route::get('/dashboard/all-users/{id}/takeoffTemplate', [adminController::class, 'takeoffTemplate_user'])->name('takeoffTemplate.user');
Route::get('/dashboard/all-users/takeoffTemplate/{id}/delete', [adminController::class, 'takeoffTemplate_delete'])->name('take0ffTemp.del');



//============ Benny FIver ===============
Route::get('/expired', [SubscriptionController::class, 'expired'])->name('expired');
Route::get('/sub', [SubscriptionController::class, 'test'])->name('showSubscription');
Route::post('/subscribe', [SubscriptionController::class, 'processSubscription'])->name('processSubscription');
Route::post('/store/payment', [SubscriptionController::class, 'postPaymentMethods'])->name('stripe.payment.store');
Route::post('/update/payment', [SubscriptionController::class, 'updatePayment'])->name('stripe.payment.update');
Route::post('/update/remove', [SubscriptionController::class, 'removePayment'])->name('stripe.payment.remove');

//Route::get('/subscribe', 'SubscriptionController@showSubscription');
//Route::post('/subscribe', 'SubscriptionController@processSubscription');
// welcome page only for subscribed users
Route::get('/welcome', 'SubscriptionController@showWelcome')->middleware('subscribed');
