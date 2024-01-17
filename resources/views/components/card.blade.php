<div {{$attributes->merge(['class'=>'bg-gray-50 border border-gray-200 rounded p-6'])}}>
{{$slot}} 
  {{-- whatever we pass in whatever we surround the tags with will be output here  --}}
</div>