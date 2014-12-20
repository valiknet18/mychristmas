<?php
namespace AppBundle\Entity;

use Mremi\UrlShortenerBundle\Entity\Link as BaseLink;
use Doctrine\ORM\Mapping as ORM;

/**
 * Class Image
 * @package AppBundle\Entity
 *
 * @ORM\Entity()
 * @ORM\Table()
 */
class Image
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\ManyToOne(targetEntity="Post", inversedBy="images", cascade={"persist"})
     */
    protected $post;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $longUrl;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set post
     *
     * @param \AppBundle\Entity\Post $post
     * @return Image
     */
    public function setPost(\AppBundle\Entity\Post $post = null)
    {
        $this->post = $post;

        return $this;
    }

    /**
     * Get post
     *
     * @return \AppBundle\Entity\Post 
     */
    public function getPost()
    {
        return $this->post;
    }

    /**
     * Set longUrl
     *
     * @param string $longUrl
     * @return Image
     */
    public function setLongUrl($longUrl)
    {
        $this->longUrl = $longUrl;

        return $this;
    }

    /**
     * Get longUrl
     *
     * @return string 
     */
    public function getLongUrl()
    {
        return $this->longUrl;
    }
}
