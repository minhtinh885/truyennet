<div class="form-group">
    <label for="name" class="col-md-2 control-label">
        Tên sách
    </label>
    <div class="col-md-10">
        <input class="form-control" type="text" value="{{$name}}" name="name">
    </div>
</div>
<div class="form-group">
    <label for="description" class="col-md-2 control-label">
        Mô tả
    </label>
    <div class="col-md-10">
        <textarea class="form-control" name="description" rows="15" id="content">{{$description}}</textarea>
    </div>
</div>
<div class="form-group">
    <label for="image_url" class="col-md-2 control-label">
        Hình ảnh
    </label>
    <div class="col-md-8">
        <input class="form-control" type="text" value="{{$image_url}}" name="image_url" id="image_url">
    </div>
    <div class="col-md-2">
        <img src="#" id="preview-image-url" class="img-responsive">
    </div>
</div>
<div class="form-group">
    <label for="source_from" class="col-md-2 control-label">
        Nguồn
    </label>
    <div class="col-md-3">
        <input class="form-control" type="text" value="{{$source_from}}" name="source_from" onchange="preview_image()">
    </div>
</div>
<div class="form-group">
    <label for="status" class="col-md-2 control-label">
        Trạng thái
    </label>
    <div class="col-md-3">
        <select class="form-control" name="status" id="status">
            <option @if($status == "Đang tiến hành") selected @endif value="Đang tiến hành">Đang tiến hành</option>
            <option @if($status == "Đã hoàn thành") selected @endif value="Đã hoàn thành">Đã hoàn thành</option>
            <option @if($status == "Tạm ngừng") selected @endif value="Tạm ngừng">Tạm ngừng</option>
        </select>
    </div>
</div>