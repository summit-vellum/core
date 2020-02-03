@if($paginator->hasPages())
<div class="clearfix mobile-modal-pb-50">
	<div class="pull-left">
		<?php
		$pages = '';
        $currentPage = 1; //$this->paginator->gitdyPage();
        $url = $paginator->url($currentPage);

        foreach ($site['pagination_items'] as $page) {
            $btnStatus = '';
            if ($paginator->perPage() == $page) {
                $btnStatus = 'disabled';
            }

            $pages .= '<a href="'.$url.'&limit='.$page.'" class="btn btn-link '.$btnStatus.'">'.$page.'</a>';
        }
        $pages .= 'items per page';
        ?>

        {!! $pages !!}
	</div>
	<div class="pull-right">
		<?php
		$offset = ($paginator->currentPage() - 1 ) * $paginator->perPage();
        $limit = $paginator->currentPage()*$paginator->perPage();

        if ($paginator->lastPage() == $paginator->currentPage()) {
            $limit = $paginator->total();
        }
        ?>
        <span class="mr-2">
            <strong>
               {{ ($offset + 1).' - '.$limit }}
            </strong> of
            <strong>{{ $paginator->total() }}</strong>
        </span>

        <!-- arrow left -->
        <?php
        $url = $paginator->previousPageUrl();
        $btnStatus = '';

        if (empty($paginator->previousPageUrl())) {
            $btnStatus = 'disabled';
        }
        ?>

        <a href="{{ $url }}" class="btn btn-link paginate-link {{ $btnStatus }}">
            @icon(['icon' => 'arrow-left'])
        </a>

        <!-- arrow right -->
        <?php
        $url = $paginator->nextPageUrl();
        $btnStatus = '';

        if (empty($paginator->nextPageUrl())) {
            $btnStatus = 'disabled';
        }
        ?>

        <a href="{{ $url }}" class="btn btn-link paginate-link {{ $btnStatus }}">
            @icon(['icon' => 'arrow-right'])
        </a>
	</div>
</div>
@endif
