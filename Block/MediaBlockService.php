<?php
/**
 * This file is part of the Presta Bundle project.
 *
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace Presta\CMSMediaBundle\Block;

use Presta\CMSCoreBundle\Block\BaseModelBlockService;
use Sonata\BlockBundle\Model\BlockInterface;
use Sonata\AdminBundle\Form\FormMapper;

/**
 * Media Block use SonataMediaBundle
 *
 * @author Nicolas Bastien <nbastien@prestaconcept.net>
 */
class MediaBlockService extends BaseModelBlockService
{
    /**
     * @var string
     */
    protected $template = 'PrestaCMSMediaBundle:Block:block_media.html.twig';

    /**
     * {@inheritdoc}
     */
    protected function getModelFields()
    {
        return array(
            'media' => 'sonata.media.admin.media'
        );
    }

    /**
     * @return mixed
     */
    public function getMediaPool()
    {
        return $this->getModelAdmin('sonata.media.admin.media')->getPool();
    }

    /**
     * Returns available formats
     *
     * @param string $context
     * @return array
     */
    protected function getFormatChoices($context = 'prestacms')
    {
        $formatChoices = array();

        $formats = $this->getMediaPool()->getFormatNamesByContext($context);

        foreach ($formats as $code => $format) {
            $formatChoices[$code] = $this->trans('media.format.' . $code);
        }

        return $formatChoices;
    }

    /**
     * {@inheritdoc}
     */
    protected function getFormSettings(FormMapper $formMapper, BlockInterface $block)
    {
        $formatChoices = $this->getFormatChoices();

        return array_merge(
            array(
                array('format', 'choice', array('required' => count($formatChoices) > 0, 'choices' => $formatChoices))
            )
          ,  parent::getFormSettings($formMapper, $block)
        );
    }


    /**
     * {@inheritdoc}
     */
    public function getDefaultSettings()
    {
        return array(
            'media' => null,
            'format' => 'prestacms_gallery_horizontal_thumb'
        );
    }
}
