<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateInternationalGuidesViewTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement($this->dropView());
        DB::statement($this->createView());
    }

    private function createView(): string
    {
        return <<<SQL
        CREATE VIEW `international_guides` AS

        SELECT tl.guide_id as id, tl.order_id as order_id, tl.external_id AS id_guide, tl.date_status AS last_status_date, gs.created_at as create_date, tl.contact as contact, gs.country as country, tl.status as status FROM tealca_datas as tl INNER JOIN guides as gs on tl.guide_id=gs.id
        UNION
        SELECT cg.id as id, cg.order_id as order_id, cg.codigo_pedido AS id_guide, cg.updated_at AS last_status_date, cg.created_at AS create_date, concat(cg.nombres_destinatario,cg.apellidos_destinatario) AS contact, ord.description AS country, cg.status as status FROM coordinadora_guides as cg INNER JOIN orders as ord on ord.id=cg.order_id;

        SQL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement($this->dropView());
    }

    private function dropView(): string
    {
        return <<<SQL

            DROP VIEW IF EXISTS `international_guides`;
            SQL;
    }
}