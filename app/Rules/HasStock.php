<?php

namespace CodeShopping\Rules;

use Illuminate\Contracts\Validation\Rule;
use CodeShopping\Models\Product;

class HasStock implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->product->stock - $value >= 0;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return "O produto {$this->product->name} não possui saldo suficiente para a saída. Seu stock é: {$this->product->stock}.";
    }
}
