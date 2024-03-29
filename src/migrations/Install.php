<?php
/**
 * Smart Google Analytics plugin for Craft CMS 3.x.
 *
 * Smart Google Analytics
 *
 * @link      https://www.zealousweb.com
 * @copyright Copyright (c) 2021 zealousweb
 */

namespace zealousweb\smartgoogleanalytics\migrations;

use Craft;
use craft\db\Migration;

/**
 * Craft Smart Google Analytics Install Migration.
 *
 * If your plugin needs to create any custom database tables when it gets installed,
 * create a migrations/ folder within your plugin folder, and save an Install.php file
 * within it using the following template:
 *
 * If you need to perform any additional actions on install/uninstall, override the
 * safeUp() and safeDown() methods.
 *
 * @author    zealousweb
 *
 * @since     1.0.0
 */
class Install extends Migration
{
    // Public Properties
    // =========================================================================

    /**
     * @var string The database driver to use
     */
    public $driver;

    // Public Methods
    // =========================================================================

    /**
     * This method contains the logic to be executed when applying this migration.
     * This method differs from [[up()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[up()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return bool return a false value to indicate the migration fails
     *              and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeUp()
    {
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        if ($this->createTables()) {
            // $this->addForeignKeys();
            // Refresh the db schema caches
            Craft::$app->db->schema->refresh();
            $this->insertDefaultData();
        }
        return true;
    }

    /**
     * This method contains the logic to be executed when removing this migration.
     * This method differs from [[down()]] in that the DB logic implemented here will
     * be enclosed within a DB transaction.
     * Child classes may implement this method instead of [[down()]] if the DB logic
     * needs to be within a transaction.
     *
     * @return bool return a false value to indicate the migration fails
     *              and should not proceed further. All other return values mean the migration succeeds.
     */
    public function safeDown()
    {
        Craft::$app->getSession()->set('google_user_access_token', '');
        $this->driver = Craft::$app->getConfig()->getDb()->driver;
        $this->removeTables();

        return true;
    }

    // Protected Methods
    // =========================================================================

    /**
     * Creates the tables needed for the Records used by the plugin.
     *
     * @return bool
     */
    protected function createTables()
    {
        $tablesCreated = false;

        // google_analytics_view_listing table
        $tableSchema = Craft::$app->db->schema->getTableSchema('{{%google_analytics_view_listing}}');
        if ($tableSchema === null) {
            $tablesCreated = true;
            $this->createTable(
                '{{%google_analytics_view_listing}}',
                [
                    'id'          => $this->primaryKey()->notNull(),
                    'account' => $this->string()->null(),
                    'gaReportType' => $this->string()->null(),
                    'gaAccountId' => $this->integer()->notNull(),
                    'property' => $this->string()->null(),
                    'gaPropertyId' => $this->string()->notNull(),
                    'views' => $this->string()->null(),
                    'gaViewId' => $this->integer()->null(),
                    'chartName'  => $this->string()->notNull(),
                    'chartType'  => $this->string()->notNull(),
                    'order' => $this->integer()->notNull(),
                    'status'  => $this->string()->null(),
                    'dimensionKey'  => $this->string()->null(),
                    'dimensionValue'  => $this->string()->null(),
                    'metricsKey'   => $this->string()->null(),
                    'metricsValue'   => $this->string()->notNull(),
                    'dateCreated' => $this->dateTime()->notNull(),
                    'dateUpdated' => $this->dateTime()->notNull(),
                    'dateDeleted' => $this->dateTime()->null(),
                    'uid'         => $this->uid(),
                ]
            );
        }

        return $tablesCreated;
    }

    /**
     * Creates the foreign keys needed for the Records used by the plugin.
     *
     * @return void
     */
    protected function addForeignKeys()
    {
        // google_analytics_view_listing table
        $this->addForeignKey(
            $this->db->getForeignKeyName('{{%google_analytics_view_listing}}', 'id'),
            '{{%google_analytics_view_listing}}',
            'id',
            null
        );
    }

    /**
     * Populates the DB with the default data.
     *
     * @return void
     */
    protected function insertDefaultData()
    {
    }

    /**
     * Removes the tables needed for the Records used by the plugin.
     *
     * @return void
     */
    protected function removeTables()
    {
        // google_analytics_view_listing table
        $this->dropTableIfExists('{{%google_analytics_view_listing}}');
    }
}
