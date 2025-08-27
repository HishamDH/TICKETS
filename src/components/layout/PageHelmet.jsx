import React from 'react';
import { Helmet } from 'react-helmet-async';

const PageHelmet = ({ title, description }) => {
  const fullTitle = `${title} | ليلة الليليوم`;
  return (
    <Helmet>
      <title>{fullTitle}</title>
      <meta name="description" content={description} />
      <meta property="og:title" content={fullTitle} />
      <meta property="og:description" content={description} />
      <meta name="twitter:title" content={fullTitle} />
      <meta name="twitter:description" content={description} />
    </Helmet>
  );
};

export default PageHelmet;