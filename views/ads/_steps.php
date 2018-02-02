<div class="agreement-steps">
	<div class="agreement-steps__mobile">
		<div class="agreement-steps__m-title">
			Основное
		</div>
		<div class="agreement-steps__m-counter">
			<svg class="b-counter-circle" xmlns="http://www.w3.org/2000/svg">
				<circle cx="20" cy="20" r="15" stroke="#e5e5e5" stroke-width="1" fill="transparent"></circle>
				<circle cx="20" cy="20" r="16" stroke="#ffc00f" stroke-width="2" fill="transparent"
				        stroke-dasharray="30,100" stroke-dashoffset="100"></circle>
				<text x="16px" y="25" font-family="Verdana" font-weight="normal" font-size="15">1</text>
			</svg>
		</div>
	</div>

	<div class="agreement-steps__items">
		<div
			class="agreement-steps__item <?= ($step == 1) ? 'agreement-steps__item--current' : 'agreement-steps__item--done'; ?>">
			<p>Основное</p>
		</div>

		<div class="agreement-steps__item <?= ($step == 2) ? 'agreement-steps__item--current' : (($step < 2) ? 'agreement-steps__item--after' : 'agreement-steps__item--done'); ?>">
			<p>Детали</p>
		</div>

		<div class="agreement-steps__item <?= ($step == 3) ? 'agreement-steps__item--current' : (($step < 3) ? 'agreement-steps__item--after' : 'agreement-steps__item--done'); ?>">
			<p>Аренда</p>
		</div>

		<div class="agreement-steps__item <?= ($step == 4) ? 'agreement-steps__item--current' : (($step < 4) ? 'agreement-steps__item--after' : 'agreement-steps__item--done'); ?>">
			<p>Фото</p>
		</div>

		<div class="agreement-steps__item <?= ($step == 5) ? 'agreement-steps__item--current' : (($step < 5) ? 'agreement-steps__item--after' : 'agreement-steps__item--done'); ?>">
			<p>Проверка</p>
		</div>

		<div class="agreement-steps__item <?= ($step == 6) ? 'agreement-steps__item--current' : (($step < 6) ? 'agreement-steps__item--after' : 'agreement-steps__item--done'); ?>">
			<p>Статус</p>
		</div>
	</div>
</div>