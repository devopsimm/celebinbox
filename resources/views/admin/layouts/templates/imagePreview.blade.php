
<div class="gallaryPreview">
    <img src="{{ ($data)?url($data->image):'' }}" alt="" height="100">
    <input type="text" value="{{ ($data)?$data->title:'' }}" class="form-control title" name="{{ ($i)?'gallaryimagename['.$data->id.']':'' }}" placeholder="Add image title">
    <input type="text" value="{{ ($data)?$data->sequence:'' }}" class="form-control order" name="{{ ($i)?'order['.$data->id.']':'' }}" placeholder="Add image Order">
    <input type="hidden" class="form-control" value="{{ ($data)?$data->id:'' }}" name="id[]">
    <a class="{{ ($data)?'removeImage':'' }}" data-id="{{ ($data)?$data->id:'' }}" href="javascript:void(0)">{{ ($data)?'X':'' }}</a>
</div>
