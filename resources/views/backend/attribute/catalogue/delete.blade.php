@include('backend.dashboard.component.breadcrumb')
@include('backend.dashboard.component.formError')
<form action="{{ route('attribute.catalogue.destroy', $attributeCatalogue->id) }}" method="post" class="box">
    @include('backend.dashboard.component.destroy')
</form>
