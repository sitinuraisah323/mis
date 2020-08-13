<script>
	let grams = {};
	let idChoice = "<?php echo $this->input->get('choice');?>";
	let sum = 0;
	class Store{
		getGrams(){
			$.ajax({
				url:"<?php echo base_url();?>/api/lm/grams",
				type:"GET",
				dataType: "JSON",
				success:function (response) {
					(new Store()).appendGram(response.data);
				},
				complete:function () {
					(new Store()).getChoice(idChoice);
				}
			})
		}
		appendGram(data){
			grams = data;
			data.forEach(data=>{
				const {weight, id, price_perpcs} = data;
				const opt = document.createElement('option');
				opt.text = weight+' Gram'+' Rp '+price_perpcs;
				opt.value = id;
				document.querySelector('.search-purchase').appendChild(opt);
			});
		}
		getChoice(id){
			const getGramById = grams.filter(gram=>{
				return gram.id == id
			});
			if(getGramById.length > 0){
				this.appendChoice(getGramById[0]);
			}
		}
		appendChoice(data){
			const {id, price_buyback_perpcs, price_perpcs, weight} = data;
			const append = document.querySelector('[data-append="choice"]');
			const template = document.querySelector('[data-template="choice"]').cloneNode(true);
			template.setAttribute('data-template','choice-cloned');
			template.querySelector('.id_lm_gram').value = id;
			template.querySelector('.price_perpcs').value = price_perpcs;
			template.querySelector('.price_perpcs').setAttribute('name','gram['+sum+'][price_perpcs]');
			template.querySelector('.price_buyback_perpcs').value = price_buyback_perpcs;
			template.querySelector('.price_buyback_perpcs').setAttribute('name','gram['+sum+'][price_buyback_perpcs]');
			template.querySelector('.amount').setAttribute('name','gram['+sum+'][amount]');
			template.querySelector('.amount').setAttribute('onKeyup','(new Store()).calculate()');
			template.querySelector('.total').setAttribute('name','gram['+sum+'][total]');
			template.querySelector('[data-post="id_lm_gram"]').textContent = weight;
			template.querySelector('.id_lm_gram').setAttribute('name','gram['+sum+'][id_lm_gram]');
			template.querySelector('[data-post="price_perpcs"]').textContent = price_perpcs;
			template.classList.remove('d-none');
			append.append(template);
			sum++;
		}
		calculate(){
			const getElementChoices = document.querySelectorAll('[data-template="choice-cloned"]');
			let total = 0;
			getElementChoices.forEach(element=>{
				const amount = parseInt(element.querySelector('.amount').value);
				const pricePerpcs = parseInt(element.querySelector('.price_perpcs').value);
				element.querySelector('.total').value = amount * pricePerpcs;
				element.querySelector('[data-post="total"]').textContent = amount * pricePerpcs;
				total += amount * pricePerpcs;
			});
			document.querySelector('[name="total"]').value = total;
		}
	}
	document.addEventListener('DOMOnload', (new Store()).getGrams())

	document.querySelector('.search-purchase').addEventListener('change', (e)=>{
		const id = e.target.value;
		(new Store()).getChoice(id);
	});

</script>
