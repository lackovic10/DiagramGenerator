<?php

namespace DiagramGenerator\Diagram;

use DiagramGenerator\Config;
use DiagramGenerator\Generator;

class Caption
{
    /**
     * @var \DiagramGenerator\Config;
     */
    protected $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
        $this->image  = new \Imagick();
    }

    /**
     * Gets the value of image.
     *
     * @return \Imagick
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Draw object which with caption text ready
     * to be added into the image
     * @return \ImagickDraw
     */
    public function getDraw()
    {
        $caption = $this->config->getCaption();
        $draw = new \ImagickDraw();
        $draw->setFont($this->getFont());
        $draw->setGravity(\Imagick::GRAVITY_CENTER);
        $draw->setFontSize($this->config->getSize()->getCaption());

        return $draw;
    }

    /**
     * @param  \ImagickDraw $draw
     * @return array
     */
    public function getMetrics(\ImagickDraw $draw)
    {
        return $this->image->queryFontMetrics($draw, $this->config->getCaption());
    }

    /**
     * Path to the font
     * TODO: move caption font to config
     * @return string
     */
    protected function getFont()
    {
        return sprintf("%s/fonts/%s", Generator::getResourcesDir(), 'arialbd.ttf');
    }
}