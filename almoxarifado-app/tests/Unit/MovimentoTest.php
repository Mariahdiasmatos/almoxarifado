<?php 
use App\Models\Produto;
use App\Models\Movimento;

test('sistema deve barrar movimentação se a quantidade de saída for maior que o estoque',function(){
    $produtoMock = new Produto([
        'nome'=>'Mouse USB Dell',
        'estoque' => 5,

    ]);
    $movimentoMock  = new Movimento([
        'quantidade'=> 10,
        'tipo'=>'s',
    ]);
    if($movimentoMock->tipo ==='s' && $movimentoMock->quantidade>$produtoMock->estoque){
        expect(true)->toBeTrue();
    }else{
        $this->fail("Erro:A regra do negócio permitiu saída de mercadoria sem estoque");

    }
});


test('O sistema deve diminuir o estoque após uma saída autorizada',function(){
    $produto = Produto::create([
        'nome'=>'Teclado mecânico',
        'estoque'=>15
    ]);

    Livewire::test(CreateMovimento::class)
        ->fillForm([
            'produto_id'=>$produto->id,
            'quantidade'=>5,
            'tipo'=>'s',
        ])
        ->call('create');
    expect(Movimento::count())->toBe(1);
    expect($produto->fresh()->estoque->toBe(10));
});

?>
