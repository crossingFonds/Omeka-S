<?php
namespace ItemHierarchy;

use Omeka\Module\AbstractModule;
use Omeka\Entity\Item;
use Laminas\ServiceManager\ServiceLocatorInterface;
use Laminas\View\Renderer\PhpRenderer;
use Laminas\Mvc\Controller\AbstractController;
use Laminas\EventManager\SharedEventManagerInterface;
use Laminas\Form\Fieldset;
use Laminas\Mvc\MvcEvent;
use Laminas\EventManager\Event;

class Module extends AbstractModule
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function install(ServiceLocatorInterface $serviceLocator)
    {
        $connection = $serviceLocator->get('Omeka\Connection');
        $connection->exec('CREATE TABLE item_hierarchy_grouping (id INT AUTO_INCREMENT NOT NULL, item_set_id INT DEFAULT NULL, hierarchy_id INT NOT NULL, parent_grouping INT DEFAULT NULL, `label` VARCHAR(255) DEFAULT NULL, INDEX IDX_888D30B9960278D7 (item_set_id), INDEX IDX_888D30B9582A8328 (hierarchy_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;');
        $connection->exec('CREATE TABLE item_hierarchy (id INT AUTO_INCREMENT NOT NULL, `label` VARCHAR(255) NOT NULL, position INT NOT NULL, UNIQUE INDEX UNIQ_F6A03E5EEA750E8 (`label`), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB;');
        $connection->exec('ALTER TABLE item_hierarchy_grouping ADD CONSTRAINT FK_888D30B9960278D7 FOREIGN KEY (item_set_id) REFERENCES item_set (id) ON DELETE CASCADE;');
        $connection->exec('ALTER TABLE item_hierarchy_grouping ADD CONSTRAINT FK_888D30B9582A8328 FOREIGN KEY (hierarchy_id) REFERENCES item_hierarchy (id) ON DELETE CASCADE;');
    }
    
    public function uninstall(ServiceLocatorInterface $serviceLocator)
    {
        $connection = $serviceLocator->get('Omeka\Connection');
        $connection->exec('ALTER TABLE item_hierarchy_grouping DROP FOREIGN KEY FK_888D30B9960278D7');
        $connection->exec('ALTER TABLE item_hierarchy_grouping DROP FOREIGN KEY FK_888D30B9582A8328');
        $connection->exec('DROP TABLE item_hierarchy');
        $connection->exec('DROP TABLE item_hierarchy_grouping');
    }

    public function attachListeners(SharedEventManagerInterface $sharedEventManager)
    {

    }
}
