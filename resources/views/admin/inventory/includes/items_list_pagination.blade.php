<div class="row">
    <nav aria-label="Page navigation example" style="margin-left:auto;margin-right:auto">
        <ul class="pagination justify-content-center">
            <li class="page-item @if(!isset($inventories->toArray()['prev_page_url']))disabled @endif">
                <a class="page-link" href="{{$inventories->toArray()['prev_page_url']}}?per_page={{$per_page}}?category_id={{$category_id}}">Previous</a>
            </li>
            <li class="page-item disabled">
                <a class="page-link" href="#">{{$inventories->toArray()['current_page']}}</a>
            </li>
            <li class="page-item @if(!isset($inventories->toArray()['next_page_url']))disabled @endif">
                <a class="page-link" href="{{$inventories->toArray()['next_page_url']}}?per_page={{$per_page}}?category_id={{$category_id}}">Next</a>
            </li>
        </ul>
    </nav>
</div>