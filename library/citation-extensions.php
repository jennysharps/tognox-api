<?php

if( class_exists( 'JLS\Citations\Citation' ) ) {

    class Extended_Citation extends JLS\Citations\Citation {

        /**
        * Returns formatted citation
        * @param int $citation_id
        * @author Jenny Sharps <jsharps85@gmail.com>
        */
        public static function getCitation( $post_id ) {

                $field_type =  parent::getFieldType( $post_id );
                    if( !$field_type ) return;

                parent::setupCitationMeta( $post_id );

                $markup = parent::$TemplateRenderer->renderView( $field_type, parent::$CitationMeta );

                // var_dump( parent::$CitationMeta);
                $attachment_id = get_post_meta( $post_id, 'custom_attachment' );
                $attachment_id = $attachment_id[0];

                if( $attachment_id ) {
                    $attachment = get_post( $attachment_id );

                    parent::$CitationMeta['attachment']['url'] =  $attachment->guid;
                    parent::$CitationMeta['attachment']['mime_type'] = str_replace( '/', '-', $attachment->post_mime_type );

                    $markup .= " <a target='_blank' class='file ". parent::$CitationMeta['attachment']['mime_type'] ."' href='" . parent::$CitationMeta['attachment']['url'] . "'>view file</a>";
                }

                return $markup;

        }

    }

    /**
     * Returns formatted citation with custom field dependent on ACF plugin
     * @param int $citation_id
     * @author Jenny Sharps <jsharps85@gmail.com>
     */
    function get_extended_citation( $citation_id ) {
            return Extended_Citation::getCitation( $citation_id );
    };
}