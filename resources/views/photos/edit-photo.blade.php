@extends('app')

@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-sm-9 col-md-5 col-lg-5">

			<h3>Edit Photo</h3>

		    <div class="thumbnail">

				<img src="{{$photo->path}}"><br><br>
				
				<form class="form-horizontal" role="form" method="POST" action="/validated/photos/edit-photo?id={{$photo->id}}" enctype="multipart/form-data">

					<input type="hidden" name="_token" value="{{ csrf_token() }}" required>


					<div class="form-group required required">
						<label class="col-md-2 control-label">Title</label>
						<div class="col-md-9">
							<input type="text" class="form-control" name="title" value="{{$photo->title}}" required>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-md-2 control-label">Description</label>
						<div class="col-md-9">
							<textarea type="text" class="form-control" name="description" rows="3" required>{{$photo->description}}</textarea>
						</div>
					</div>

					<div class="form-group required">
						<label class="col-md-2 control-label">Change image (max. 20MB)</label>
						<div class="col-md-9">
							<input type="file" class="form-control" name="image">
						</div>
					</div>

					<div class="form-group">
						<div class="col-md-9 col-md-offset-2">
							<button type="submit" class="btn btn-primary">
								Update Photo
							</button>
							<a class="btn btn-default" href="javascript:history.back()">Cancel</a>
						</div>
					</div>

				</form>

			</div>
		</div>
	</div>

</div>
@endsection