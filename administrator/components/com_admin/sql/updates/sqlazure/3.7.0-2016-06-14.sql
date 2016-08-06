CREATE TABLE [#__share_draft] (
  [id]         [int] unsigned NOT NULL AUTO_INCREMENT,
  [articleId]  [int] unsigned NOT NULL,
  [created]    [datetime]      NOT NULL,
  [sharetoken] [nvarchar](255) NOT NULL,
  CONSTRAINT [PK_#__id] PRIMARY KEY CLUSTERED
    (
      [id] ASC
    )
) ON [PRIMARY];