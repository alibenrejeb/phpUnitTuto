<?php

class ConnectionTest extends \PHPUnit\DbUnit\TestCase
{

    /**
     * Returns the test database connection.
     *
     * @return \PHPUnit\DbUnit\Database\Connection
     */
    protected function getConnection()
    {
        $database = 'myguestbook';
        $user = 'root';
        $password = '';
        $pdo = new PDO('mysql:host=localhost;dbname=myguestbook', $user, $password);
        $pdo->exec('CREATE TABLE IF NOT EXISTS guestbook (id int, content text, user text, created text)');
        return $this->createDefaultDBConnection($pdo, $database);
    }

    /**
     * Returns the test dataset.
     *
     * @return \PHPUnit\DbUnit\DataSet\IDataSet
     */
    protected function getDataSet()
    {
        return $this->createFlatXMLDataSet(dirname(__DIR__) . '/dataSets/myFlatXmlFixture.xml');
    }

    public function testGetRowCount()
    {
        $this->assertEquals(2, $this->getConnection()->getRowCount('guestbook'));
    }
}