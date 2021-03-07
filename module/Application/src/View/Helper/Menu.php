<?php
namespace Application\View\Helper;

use Laminas\View\Helper\AbstractHelper;

/**
 * This view helper class displays a menu bar.
 */
class Menu extends AbstractHelper
{
    /**
     * Menu items array.
     * @var array
     */
    protected $items = [];

    /**
     * Active item's ID.
     * @var string
     */
    protected $activeItemId = '';

    /**
     * Constructor.
     * @param array $items Menu items.
     */
    public function __construct($items=[])
    {
        $this->items = $items;
    }

    /**
     * Sets menu items.
     * @param array $items Menu items.
     */
    public function setItems($items)
    {
        $this->items = $items;
    }

    /**
     * Sets ID of the active items.
     * @param string $activeItemId
     */
    public function setActiveItemId($activeItemId)
    {
        $this->activeItemId = $activeItemId;
    }

    /**
     * Renders the menu.
     * @return string HTML code of the menu.
     */
    public function render()
    {
        if (count($this->items)==0)
            return ''; // Do nothing if there are no items.

        $result = '<nav class="pcoded-navbar menupos-fixed menu-light ">';
            $result .= '<div class="navbar-wrapper ">';
                $result .= '<div class="navbar-content scroll-div ">';
                    $result .= '<ul class="nav pcoded-inner-navbar ">';
                        $result .= '<li class="nav-item pcoded-menu-caption"><label>Navegación</label></li>';

                    // Render items
                    foreach ($this->items as $item) {
                            $result .= $this->renderItem($item);
                    }

                    $result .= '</ul>';
                $result .= '</div>';
            $result .= '</div>';
        $result .= '</nav>';

        return $result;

    }

    /**
     * Renders an item.
     * @param array $item The menu item info.
     * @return string HTML code of the item.
     */
    protected function renderItem($item)
    {
        $id = isset($item['id']) ? $item['id'] : '';
        $label = isset($item['label']) ? $item['label'] : '';
        $icon = isset($item['icon']) ? $item['icon'] : '';

        $result = '';

        $escapeHtml = $this->getView()->plugin('escapeHtml');

        if (isset($item['dropdown'])) {

            $dropdownItems = $item['dropdown'];

            $result .= '<li class="nav-item pcoded-hasmenu">';
                $result .= '<a href="#" class="nav-link ">';
                $result .= '<span class="pcoded-micon"><i class="'.$icon.'" ></i></span>';
                $result .= '<span class="pcoded-mtext">' . $label . '</span>';
                $result .= '</a>';

                $result .= '<ul class="pcoded-submenu">';

                foreach ($dropdownItems as $item) {
                    $link = isset($item['link']) ? $item['link'] : '#';
                    $label = isset($item['label']) ? $item['label'] : '';

                    $result .= '<li><a href="' . $link . '" >' . $label . '</a></li>';
                }

                $result .= '</ul></ul>';
            $result .= '</li>';

        } else {
            $link = isset($item['link']) ? $item['link'] : '#';

            if ($item['link']) {
                $result .= '<li class="nav-item">';
                    $result .= '<a href="' . $link . '" class="nav-link">';
                        $result .= '<span class="pcoded-micon"><i class="'.$icon.'"></i></span>';
                    $result .= '<span class="pcoded-mtext">' . $label . '</span>';
                    $result .= '</a>';
                $result .= '</li>';
            } else {
                $result = '';
            }
        }

        return $result;
    }
}
