<?php

namespace App\Services;

interface iCompanyService
{
    /**
     * Get all the company items
     *
     * @return Company
     */
    public function getCompanyAll();

    /**
     * get the company of the city
     *
     * @return Company
     */
    public function getCompanyCity();

    /**
     * get a company by the  user friendly slug
     *
     * @param string $slug - A user friendly url
     *
     * @return Company
     */
    public function getCompanyBySlug($slug);

    /**
     * get a Company with the id.
     *
     * @param int $id - the id of a company
     *
     * @return Company
     */
    public function getCompanyById($id);

    /**
     * get all company for the adm overview.
     *
     * @return Company
     */
    public function getCompanyADMOverview();

    /**
     * get all companies with mutations
     *
     * @return CompanyShadow
     */
    public function getCompanyMutationOverview();
}
