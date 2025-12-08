<?php

namespace App\Rules;

use App\Models\Menu;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class SufficientStock implements ValidationRule
{
    private int $menuId;

    public function __construct(int $menuId)
    {
        $this->menuId = $menuId;
    }

    /**
     * Run the validation rule.
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $menu = Menu::find($this->menuId);

        if (!$menu) {
            $fail('Menu tidak ditemukan.');
            return;
        }

        if ($menu->stok < $value) {
            $fail("Stok tidak mencukupi. Stok tersedia: {$menu->stok}");
            return;
        }
    }
}
