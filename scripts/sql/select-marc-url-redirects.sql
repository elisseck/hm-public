SELECT
    nf_an.field_accession_number_value,
    pa.alias as to_url
FROM
    node__field_accession_number nf_an
        JOIN
    node n ON n.nid = nf_an.entity_id
        JOIN
    path_alias pa ON CONCAT("/node/", n.nid) = pa.path